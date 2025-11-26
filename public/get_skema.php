<?php
// get_skema.php - Improved version with better error handling and debugging
require_once 'config.php';
require_once 'skema_functions.php';

// Set proper headers
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors in output
ini_set('log_errors', 1);

// Function to send JSON response and exit
function sendJsonResponse($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Function to log and send error
function sendError($message, $details = null) {
    $errorData = ['success' => false, 'message' => $message];
    if ($details && $_GET['debug'] ?? false) {
        $errorData['details'] = $details;
    }
    error_log("get_skema.php Error: $message" . ($details ? " - Details: " . print_r($details, true) : ""));
    sendJsonResponse($errorData);
}

try {
    // Validate input
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        sendError('ID skema tidak ditemukan atau kosong');
    }
    
    $skema_id = trim($_GET['id']);
    
    // Validate ID is numeric
    if (!is_numeric($skema_id)) {
        sendError('ID skema harus berupa angka', ['provided_id' => $skema_id]);
    }
    
    $skema_id = intval($skema_id);
    
    if ($skema_id <= 0) {
        sendError('ID skema tidak valid', ['provided_id' => $skema_id]);
    }
    
    // Initialize SkemaManager
    $skemaManager = new SkemaManager($conn);
    
    // Get skema data
    $skema = $skemaManager->getSkemaById($skema_id);
    
    if (!$skema) {
        sendError('Skema tidak ditemukan', ['skema_id' => $skema_id]);
    }
    
    // Get related data
    $units = $skemaManager->getUnitKompetensiBySkemaId($skema_id);
    $persyaratan = $skemaManager->getPersyaratanBySkemaId($skema_id);
    $dokumen = $skemaManager->getDokumenPersyaratanBySkemaId($skema_id);
    $asesmen = $skemaManager->getMetodeAsesmenBySkemaId($skema_id);
    $pemeliharaan = $skemaManager->getPemeliharaanBySkemaId($skema_id);
    $metode_pengujian = $skemaManager->getMetodePengujianBySkemaId($skema_id); // Ambil data metode pengujian
    
    // Debug logging
    error_log("get_skema.php - Skema data: " . print_r($skema, true));
    error_log("get_skema.php - Units count: " . count($units));
    error_log("get_skema.php - Persyaratan count: " . count($persyaratan));
    error_log("get_skema.php - Dokumen count: " . count($dokumen));
    error_log("get_skema.php - Asesmen count: " . count($asesmen));
    error_log("get_skema.php - Pemeliharaan count: " . count($pemeliharaan));
    
    // Prepare response
    $response = [
        'success' => true,
        'skema' => $skema,
        'units' => [],
        'persyaratan' => [],
        'dokumen' => [],
        'asesmen' => []
    ];
    
    // Process units
    if ($units && is_array($units)) {
        $response['units'] = array_map(function($unit) {
            return [
                'nomor' => $unit['no_urut'] ?? $unit['nomor'] ?? '',
                'kode_unit' => $unit['kode_unit'] ?? '',
                'judul' => $unit['judul_unit'] ?? $unit['judul'] ?? '',
                'standar_kompetensi' => $unit['standar_kompetensi'] ?? ''
            ];
        }, $units);
    }
    
    // Process persyaratan
    if ($persyaratan && is_array($persyaratan)) {
        $response['persyaratan'] = array_map(function($req) {
            if (is_array($req)) {
                return [
                    'deskripsi' => $req['deskripsi'] ?? $req['persyaratan'] ?? ''
                ];
            } else {
                return ['deskripsi' => $req];
            }
        }, $persyaratan);
    }
    
    // Process dokumen
    if ($dokumen && is_array($dokumen)) {
        $response['dokumen'] = array_map(function($doc) {
            return [
                'nama' => $doc['nama_dokumen'] ?? $doc['nama'] ?? '',
                'wajib' => intval($doc['wajib'] ?? 1)
            ];
        }, $dokumen);
    }
    
    // Process asesmen
    if ($asesmen && is_array($asesmen)) {
        $response['asesmen'] = array_map(function($asesmenItem) {
            return [
                'jenis_peserta' => $asesmenItem['jenis_peserta'] ?? '',
                'metode' => $asesmenItem['metode'] ?? '',
                'deskripsi' => $asesmenItem['deskripsi'] ?? ''
            ];
        }, $asesmen);
    }
    
    // Process pemeliharaan - multiple fallback strategies
    $pemeliharaanValue = '';
    
    // Strategy 1: Check if it's directly in skema
    if (isset($skema['pemeliharaan']) && !empty($skema['pemeliharaan'])) {
        $pemeliharaanValue = $skema['pemeliharaan'];
    }
    // Strategy 2: Check pemeliharaan array
    else if ($pemeliharaan && is_array($pemeliharaan) && count($pemeliharaan) > 0) {
        $firstPemeliharaan = $pemeliharaan[0];
        if (is_array($firstPemeliharaan)) {
            $pemeliharaanValue = $firstPemeliharaan['deskripsi'] ?? 
                               $firstPemeliharaan['pemeliharaan'] ?? '';
        } else {
            $pemeliharaanValue = $firstPemeliharaan;
        }
    }
    
    // Set pemeliharaan in skema
    $response['skema']['pemeliharaan'] = $pemeliharaanValue;

    // Set metode_pengujian in skema if $skema is not null
    if ($response['skema']) {
        $response['skema']['metode_pengujian'] = $metode_pengujian;
    }
    
    // Additional debugging info if requested
    if (isset($_GET['debug']) && $_GET['debug']) {
        $response['debug'] = [
            'raw_skema' => $skema,
            'raw_units' => $units,
            'raw_persyaratan' => $persyaratan,
            'raw_dokumen' => $dokumen,
            'raw_asesmen' => $asesmen,
            'raw_pemeliharaan' => $pemeliharaan,
            'pemeliharaan_value' => $pemeliharaanValue,
            'raw_metode_pengujian' => $metode_pengujian, // Tambahkan untuk debug
            'server_time' => date('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION
        ];
    }
    
    // Log successful response
    error_log("get_skema.php - Successfully prepared response for skema ID: $skema_id");
    
    // Send response
    sendJsonResponse($response);
    
} catch (Exception $e) {
    error_log("get_skema.php - Exception: " . $e->getMessage());
    error_log("get_skema.php - Stack trace: " . $e->getTraceAsString());
    
    sendError(
        'Terjadi kesalahan server: ' . $e->getMessage(),
        [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]
    );
} catch (Error $e) {
    error_log("get_skema.php - Fatal Error: " . $e->getMessage());
    error_log("get_skema.php - Stack trace: " . $e->getTraceAsString());
    
    sendError(
        'Terjadi kesalahan fatal: ' . $e->getMessage(),
        [
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    );
}

// This should never be reached, but just in case
sendError('Unknown error occurred');
?>