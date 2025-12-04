<?php

function parse_numbered_list($text) {
    if (empty($text)) {
        return [];
    }
    $lines = explode("\n", $text);
    $items = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) {
            continue;
        }
        // Remove leading numbers like "1. ", "2. "
        $cleaned = preg_replace('/^\d+\.\s*/', '', $line);
        if ($cleaned) {
            $items[] = $cleaned;
        }
    }
    return $items;
}

function main() {
    $data = [];
    
    // Read part 1
    $json1 = file_get_contents('sql/data_part1.json');
    if ($json1 === false) {
        die("Error reading data_part1.json");
    }
    $data1 = json_decode($json1, true);
    if ($data1 === null) {
        die("Error decoding data_part1.json");
    }
    $data = array_merge($data, $data1);
    
    // Read part 2
    $json2 = file_get_contents('sql/data_part2.json');
    if ($json2 === false) {
        die("Error reading data_part2.json");
    }
    $data2 = json_decode($json2, true);
    if ($data2 === null) {
        die("Error decoding data_part2.json");
    }
    $data = array_merge($data, $data2);

    $sql_statements = [];
    
    // Start transaction
    $sql_statements[] = "START TRANSACTION;";
    
    foreach ($data as $item) {
        $no = $item['no'];
        $kode = isset($item['kode_skema']) ? $item['kode_skema'] : 'N/A';
        if ($kode === 'N/A') {
            $kode = sprintf("SKM-GEN-%03d", $no);
        }
            
        $nama = $item['nama_skema'];
        $jenis = $item['jenis'];
        $harga = $item['harga']['sk'];
        // Count unit kompetensi
        $units = isset($item['unit_kompetensi']) ? $item['unit_kompetensi'] : [];
        $num_units = count($units);
        
        // Ringkasan from KBLI/KBJI
        $kbli = isset($item['kbli']) ? $item['kbli'] : [];
        $kbji = isset($item['kbji']) ? $item['kbji'] : [];
        $kbli_kode = isset($kbli['kode']) ? $kbli['kode'] : '';
        $kbli_uraian = isset($kbli['uraian']) ? $kbli['uraian'] : '';
        $kbji_kode = isset($kbji['kode']) ? $kbji['kode'] : '';
        $kbji_uraian = isset($kbji['uraian']) ? $kbji['uraian'] : '';
        
        $ringkasan = "KBLI: $kbli_kode - $kbli_uraian. KBJI: $kbji_kode - $kbji_uraian";
        
        // Escape strings
        $nama_esc = str_replace("'", "''", $nama);
        $kode_esc = str_replace("'", "''", $kode);
        $jenis_esc = str_replace("'", "''", $jenis);
        $ringkasan_esc = str_replace("'", "''", $ringkasan);
        
        // Insert Skema
        $sql = "INSERT INTO `skema` (`nama`, `kode`, `jenis`, `harga`, `unit_kompetensi`, `ringkasan`, `masa_berlaku`) VALUES ('$nama_esc', '$kode_esc', '$jenis_esc', $harga, $num_units, '$ringkasan_esc', '3 Tahun');";
        $sql_statements[] = $sql;
        
        // Set variable for current skema id
        $sql_statements[] = "SET @skema_id = LAST_INSERT_ID();";
        
        // Insert Unit Kompetensi
        $idx = 1;
        foreach ($units as $unit) {
            $kode_unit = str_replace("'", "''", $unit['kode']);
            $judul_unit = str_replace("'", "''", $unit['judul']);
            $sql = "INSERT INTO `unit_kompetensi` (`skema_id`, `no_urut`, `kode_unit`, `judul_unit`) VALUES (@skema_id, $idx, '$kode_unit', '$judul_unit');";
            $sql_statements[] = $sql;
            $idx++;
        }
            
        // Insert Persyaratan
        $persyaratan_text = isset($item['persyaratan']['dasar']) ? $item['persyaratan']['dasar'] : '';
        $persyaratan_items = parse_numbered_list($persyaratan_text);
        foreach ($persyaratan_items as $p_item) {
            $p_item_esc = str_replace("'", "''", $p_item);
            $sql = "INSERT INTO `persyaratan` (`skema_id`, `deskripsi`) VALUES (@skema_id, '$p_item_esc');";
            $sql_statements[] = $sql;
        }
            
        // Insert Dokumen Persyaratan
        $dokumen_text = isset($item['persyaratan']['dokumen']) ? $item['persyaratan']['dokumen'] : '';
        $dokumen_items = parse_numbered_list($dokumen_text);
        foreach ($dokumen_items as $d_item) {
            $d_item_esc = str_replace("'", "''", $d_item);
            $sql = "INSERT INTO `dokumen_persyaratan` (`skema_id`, `nama_dokumen`, `wajib`) VALUES (@skema_id, '$d_item_esc', 1);";
            $sql_statements[] = $sql;
        }
            
        $sql_statements[] = ""; // Empty line separator
    }

    $sql_statements[] = "COMMIT;";
    
    file_put_contents('sql/insert_data.sql', implode("\n", $sql_statements));
    echo "Successfully generated sql/insert_data.sql\n";
}

main();
?>
