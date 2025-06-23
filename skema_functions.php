<?php
// skema_functions.php - Fixed Version
require_once 'config.php';

class SkemaManager {
    private $db;
    
    public function __construct($pdo = null) {
        global $conn;
        $this->db = $pdo ?: $conn;
        
        if (!$this->db) {
            throw new Exception("Database connection is required");
        }
    }
    
    private function uploadGambar($file, $existingFile = null) {
        // Path sesuai dengan yang di database - langsung ke assets/img/
        $uploadDir = __DIR__ . '/dksassets/img/';
        
        // Pastikan folder assets/img ada
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Debug: Cek apakah folder bisa ditulis
        if (!is_writable($uploadDir)) {
            throw new Exception("Folder upload tidak bisa ditulis: " . $uploadDir);
        }
        
        // Validasi file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            if ($file['error'] === UPLOAD_ERR_NO_FILE) {
                return $existingFile; // Tidak ada file yang diupload, kembalikan yang sudah ada
            }
            throw new Exception("Error uploading file: " . $file['error']);
        }
        
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Hanya file gambar (JPG, PNG, GIF) yang diperbolehkan");
        }
        
        if ($file['size'] > $maxSize) {
            throw new Exception("Ukuran file maksimal 2MB");
        }
        
        // Generate nama file unik (sama seperti di database)
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('skema_') . '.' . strtolower($extension);
        $targetPath = $uploadDir . $filename;
        
        // Debug: Tampilkan path untuk debugging
        error_log("Target upload path: " . $targetPath);
        error_log("File temp name: " . $file['tmp_name']);
        
        // Pindahkan file ke folder upload
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new Exception("Gagal menyimpan file ke: " . $targetPath);
        }
        
        // Cek apakah file benar-benar tersimpan
        if (!file_exists($targetPath)) {
            throw new Exception("File tidak ditemukan setelah upload: " . $targetPath);
        }
        
        // Hapus file lama jika ada
        if ($existingFile && file_exists($uploadDir . $existingFile)) {
            unlink($uploadDir . $existingFile);
        }
        
        // Return hanya nama file (bukan path lengkap) untuk disimpan ke database
        return $filename;
    }
    
    
    /**
     * Get all skema records
     */
    public function getAllSkema() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM skema ORDER BY created_at DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all skema: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get skema by ID (just the main record)
     */
    public function getSkemaById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM skema WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting skema by ID: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get skema by ID with all related data
     */
    public function getSkemaComplete($id) {
        try {
            // Get main skema data
            $stmt = $this->db->prepare("SELECT * FROM skema WHERE id = ?");
            $stmt->execute([$id]);
            $skema = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$skema) {
                return null;
            }
            
            // Get related data
            $result = [
                'skema' => $skema,
                'unit_kompetensi' => $this->getUnitKompetensiBySkemaId($id),
                'persyaratan' => $this->getPersyaratanBySkemaId($id),
                'dokumen' => $this->getDokumenPersyaratanBySkemaId($id),
                'metode_asesmen' => $this->getMetodeAsesmenBySkemaId($id),
                'pemeliharaan' => $this->getPemeliharaanBySkemaId($id),
                // Mengambil dan menambahkan metode_pengujian_skema ke hasil
                'metode_pengujian_skema' => $this->getMetodePengujianBySkemaId($id)
            ];

            // Memastikan metode_pengujian juga ada di dalam array 'skema' untuk kompatibilitas JS yang ada
            // dan untuk pengisian form edit.
            if ($result['skema']) { // Pastikan $skema tidak null
                $result['skema']['metode_pengujian'] = $result['metode_pengujian_skema'];
            }
            
            return $result;
            
        } catch (PDOException $e) {
            error_log("Error getting complete skema by ID: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get unit kompetensi by skema ID - NOW PUBLIC
     */
    public function getUnitKompetensiBySkemaId($skema_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM unit_kompetensi WHERE skema_id = ? ORDER BY no_urut");
            $stmt->execute([$skema_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting unit kompetensi: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get persyaratan by skema ID - NOW PUBLIC
     */
    public function getPersyaratanBySkemaId($skema_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM persyaratan WHERE skema_id = ?");
            $stmt->execute([$skema_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting persyaratan: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get dokumen persyaratan by skema ID - NOW PUBLIC
     */
    public function getDokumenPersyaratanBySkemaId($skema_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM dokumen_persyaratan WHERE skema_id = ?");
            $stmt->execute([$skema_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting dokumen persyaratan: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get metode asesmen by skema ID - NOW PUBLIC
     */
    public function getMetodeAsesmenBySkemaId($skema_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM metode_asesmen WHERE skema_id = ?");
            $stmt->execute([$skema_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting metode asesmen: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get pemeliharaan by skema ID - NOW PUBLIC
     */
    public function getPemeliharaanBySkemaId($skema_id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM pemeliharaan WHERE skema_id = ?");
            $stmt->execute([$skema_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting pemeliharaan: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Create a complete skema with all related data
     */
    public function createSkemaComplete($data) {
        try {
            $this->db->beginTransaction();
            
            // Handle file upload
            $gambar = null;
            if (!empty($_FILES['gambar']['name'])) {
                $gambar = $this->uploadGambar($_FILES['gambar']);
            }
            
            // Insert main skema record
            $stmt = $this->db->prepare("
                INSERT INTO skema (nama, kode, jenis, harga, unit_kompetensi, masa_berlaku, ringkasan, gambar, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $stmt->execute([
                $data['nama'],
                $data['kode'],
                $data['jenis'],
                $data['harga'],
                $data['unit_kompetensi'],
                $data['masa_berlaku'] ?? 3,
                $data['ringkasan'],
                $gambar
            ]);
            
            $skema_id = $this->db->lastInsertId();
            
            // Insert related data
            $this->insertRelatedData($skema_id, $data);
            
            $this->db->commit();
            return $skema_id;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating skema: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function updateSkemaComplete($data) {
        try {
            $this->db->beginTransaction();
            
            // Handle file upload
            $gambar = $data['existing_gambar'] ?? null;
            if (!empty($_FILES['gambar']['name'])) {
                $gambar = $this->uploadGambar($_FILES['gambar'], $gambar);
            }
            
            // Update main skema record
            $stmt = $this->db->prepare("
                UPDATE skema 
                SET nama = ?, kode = ?, jenis = ?, harga = ?, unit_kompetensi = ?, 
                    masa_berlaku = ?, ringkasan = ?, gambar = ?, updated_at = NOW()
                WHERE id = ?
            ");
            
            $stmt->execute([
                $data['nama'],
                $data['kode'],
                $data['jenis'],
                $data['harga'],
                $data['unit_kompetensi'],
                $data['masa_berlaku'] ?? 3,
                $data['ringkasan'],
                $gambar,
                $data['skema_id']
            ]);
            
            $skema_id = $data['skema_id'];
            
            // Delete existing related data
            $this->deleteRelatedData($skema_id);
            
            // Insert new related data
            $this->insertRelatedData($skema_id, $data);
            
            $this->db->commit();
            return true;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error updating skema: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Delete a skema and all related data
     */
    public function deleteSkema($skema_id) {
        try {
            $this->db->beginTransaction();
            
            // Delete related records first (due to foreign key constraints)
            $this->deleteRelatedData($skema_id);
            
            // Delete main skema record
            $stmt = $this->db->prepare("DELETE FROM skema WHERE id = ?");
            $stmt->execute([$skema_id]);
            
            $this->db->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting skema: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Check if skema code already exists
     */
    public function isKodeExists($kode, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM skema WHERE kode = ?";
        $params = [$kode];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Get skema statistics
     */
    public function getSkemaStats() {
        try {
            $stats = [];
            
            // Total skema
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM skema");
            $stmt->execute();
            $stats['total'] = $stmt->fetchColumn();
            
            // By jenis
            $stmt = $this->db->prepare("SELECT jenis, COUNT(*) as count FROM skema GROUP BY jenis");
            $stmt->execute();
            $stats['by_jenis'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $stats;
            
        } catch (PDOException $e) {
            error_log("Error getting skema stats: " . $e->getMessage());
            return null;
        }
    }
    
    // PRIVATE HELPER METHODS BELOW
    private function insertRelatedData($skema_id, $data) {
        // Insert unit kompetensi
        if (isset($data['kode_unit']) && is_array($data['kode_unit'])) {
            $this->insertUnitKompetensi($skema_id, $data);
        }
        
        // Insert persyaratan
        if (isset($data['persyaratan']) && is_array($data['persyaratan'])) {
            $this->insertPersyaratan($skema_id, $data['persyaratan']);
        }
        
        // Insert dokumen persyaratan
        if (isset($data['dokumen_nama']) && is_array($data['dokumen_nama'])) {
            $this->insertDokumen($skema_id, $data);
        }
        
        // Insert metode asesmen
        if (isset($data['asesmen_jenis']) && is_array($data['asesmen_jenis'])) {
            $this->insertMetodeAsesmen($skema_id, $data);
        }
        
        // Insert pemeliharaan
        if (isset($data['pemeliharaan']) && !empty($data['pemeliharaan'])) {
            $this->insertPemeliharaan($skema_id, $data['pemeliharaan']);
        }

        // Insert metode pengujian
        if (isset($data['metode_pengujian_skema']) && !empty($data['metode_pengujian_skema'])) {
            $this->insertMetodePengujian($skema_id, $data['metode_pengujian_skema']);
        }
    }
    
    private function deleteRelatedData($skema_id) {
        $tables = ['unit_kompetensi', 'persyaratan', 'dokumen_persyaratan', 'metode_asesmen', 'pemeliharaan', 'skema_metode_pengujian'];
        
        foreach ($tables as $table) {
            $stmt = $this->db->prepare("DELETE FROM {$table} WHERE skema_id = ?");
            $stmt->execute([$skema_id]);
        }
    }
    
    private function insertUnitKompetensi($skema_id, $data) {
        $stmt = $this->db->prepare("
            INSERT INTO unit_kompetensi (skema_id, no_urut, kode_unit, judul_unit, standar_kompetensi, lampiran_file) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
    
        for ($i = 0; $i < count($data['kode_unit']); $i++) {
            if (!empty($data['kode_unit'][$i])) {
                $stmt->execute([
                    $skema_id,
                    $data['unit_no'][$i] ?? ($i + 1),
                    $data['kode_unit'][$i],
                    $data['unit_judul'][$i] ?? '',
                    $data['unit_standar'][$i] ?? '',
                    $data['unit_lampiran'][$i] ?? null
                ]);
            }
        }
    }
    
    private function insertPersyaratan($skema_id, $persyaratan_array) {
        $stmt = $this->db->prepare("INSERT INTO persyaratan (skema_id, deskripsi) VALUES (?, ?)");
        
        foreach ($persyaratan_array as $persyaratan) {
            if (!empty($persyaratan)) {
                $stmt->execute([$skema_id, $persyaratan]);
            }
        }
    }
    
    private function insertDokumen($skema_id, $data) {
        $stmt = $this->db->prepare("INSERT INTO dokumen_persyaratan (skema_id, nama_dokumen, wajib) VALUES (?, ?, ?)");
        
        for ($i = 0; $i < count($data['dokumen_nama']); $i++) {
            if (!empty($data['dokumen_nama'][$i])) {
                $wajib = isset($data['dokumen_wajib'][$i]) ? 1 : 0;
                $stmt->execute([$skema_id, $data['dokumen_nama'][$i], $wajib]);
            }
        }
    }
    
    private function insertMetodeAsesmen($skema_id, $data) {
        $stmt = $this->db->prepare("
            INSERT INTO metode_asesmen (skema_id, jenis_peserta, metode, deskripsi) 
            VALUES (?, ?, ?, ?)
        ");
        
        for ($i = 0; $i < count($data['asesmen_jenis']); $i++) {
            if (!empty($data['asesmen_jenis'][$i])) {
                $stmt->execute([
                    $skema_id,
                    $data['asesmen_jenis'][$i],
                    $data['asesmen_metode'][$i] ?? '',
                    $data['asesmen_deskripsi'][$i] ?? ''
                ]);
            }
        }
    }
    
    private function insertPemeliharaan($skema_id, $deskripsi) {
        if (!empty($deskripsi)) {
            $stmt = $this->db->prepare("INSERT INTO pemeliharaan (skema_id, deskripsi) VALUES (?, ?)");
            $stmt->execute([$skema_id, $deskripsi]);
        }
    }

    private function insertMetodePengujian($skema_id, $metode_pengujian) {
        if (!empty($metode_pengujian)) {
            $stmt = $this->db->prepare("INSERT INTO skema_metode_pengujian (skema_id, metode_pengujian) VALUES (?, ?)");
            $stmt->execute([$skema_id, $metode_pengujian]);
        }
    }

    public function getMetodePengujianBySkemaId($skema_id) {
        try {
            $stmt = $this->db->prepare("SELECT metode_pengujian FROM skema_metode_pengujian WHERE skema_id = ?");
            $stmt->execute([$skema_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['metode_pengujian'] : null;
        } catch (PDOException $e) {
            error_log("Error getting metode pengujian by skema ID: " . $e->getMessage());
            return null;
        }
    }

    public function getGambarPath($filename) {
        if (empty($filename)) {
            return null;
        }
        return 'dksassets/img/' . $filename;
    }
    
}
?>