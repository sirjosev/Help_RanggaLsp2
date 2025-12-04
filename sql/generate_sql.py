import json
import re

def parse_numbered_list(text):
    if not text:
        return []
    # Split by newline
    lines = text.split('\n')
    items = []
    for line in lines:
        line = line.strip()
        if not line:
            continue
        # Remove leading numbers like "1. ", "2. "
        cleaned = re.sub(r'^\d+\.\s*', '', line)
        if cleaned:
            items.append(cleaned)
    return items

def main():
    data = []
    # Read part 1
    with open('sql/data_part1.json', 'r', encoding='utf-8') as f:
        data.extend(json.load(f))
    # Read part 2
    with open('sql/data_part2.json', 'r', encoding='utf-8') as f:
        data.extend(json.load(f))

    sql_statements = []
    
    # Start transaction
    sql_statements.append("START TRANSACTION;")
    
    # We need to know the starting ID for skema? 
    # Since we are generating INSERT statements, we can let AUTO_INCREMENT handle it,
    # but we need the ID for foreign keys.
    # We can use LAST_INSERT_ID() in SQL variables.
    
    for item in data:
        no = item['no']
        kode = item.get('kode_skema', 'N/A')
        if kode == 'N/A':
            kode = f"SKM-GEN-{no:03d}"
            
        nama = item['nama_skema']
        jenis = item['jenis']
        harga = item['harga']['sk']
        # Count unit kompetensi
        units = item.get('unit_kompetensi', [])
        num_units = len(units)
        
        # Ringkasan from KBLI/KBJI
        kbli = item.get('kbli', {})
        kbji = item.get('kbji', {})
        ringkasan = f"KBLI: {kbli.get('kode','')} - {kbli.get('uraian','')}. KBJI: {kbji.get('kode','')} - {kbji.get('uraian','')}"
        
        # Escape strings
        nama_esc = nama.replace("'", "''")
        kode_esc = kode.replace("'", "''")
        jenis_esc = jenis.replace("'", "''")
        ringkasan_esc = ringkasan.replace("'", "''")
        
        # Insert Skema
        sql = f"INSERT INTO `skema` (`nama`, `kode`, `jenis`, `harga`, `unit_kompetensi`, `ringkasan`, `masa_berlaku`) VALUES ('{nama_esc}', '{kode_esc}', '{jenis_esc}', {harga}, {num_units}, '{ringkasan_esc}', '3 Tahun');"
        sql_statements.append(sql)
        
        # Set variable for current skema id
        sql_statements.append("SET @skema_id = LAST_INSERT_ID();")
        
        # Insert Unit Kompetensi
        for idx, unit in enumerate(units, 1):
            kode_unit = unit['kode'].replace("'", "''")
            judul_unit = unit['judul'].replace("'", "''")
            sql = f"INSERT INTO `unit_kompetensi` (`skema_id`, `no_urut`, `kode_unit`, `judul_unit`) VALUES (@skema_id, {idx}, '{kode_unit}', '{judul_unit}');"
            sql_statements.append(sql)
            
        # Insert Persyaratan
        persyaratan_text = item.get('persyaratan', {}).get('dasar', '')
        persyaratan_items = parse_numbered_list(persyaratan_text)
        for p_item in persyaratan_items:
            p_item_esc = p_item.replace("'", "''")
            sql = f"INSERT INTO `persyaratan` (`skema_id`, `deskripsi`) VALUES (@skema_id, '{p_item_esc}');"
            sql_statements.append(sql)
            
        # Insert Dokumen Persyaratan
        dokumen_text = item.get('persyaratan', {}).get('dokumen', '')
        dokumen_items = parse_numbered_list(dokumen_text)
        for d_item in dokumen_items:
            d_item_esc = d_item.replace("'", "''")
            sql = f"INSERT INTO `dokumen_persyaratan` (`skema_id`, `nama_dokumen`, `wajib`) VALUES (@skema_id, '{d_item_esc}', 1);"
            sql_statements.append(sql)
            
        sql_statements.append("") # Empty line separator

    sql_statements.append("COMMIT;")
    
    with open('sql/insert_data.sql', 'w', encoding='utf-8') as f:
        f.write('\n'.join(sql_statements))

if __name__ == '__main__':
    main()
