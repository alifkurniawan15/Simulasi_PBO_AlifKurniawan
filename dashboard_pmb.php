<?php
// Memanggil komponen database dan model kelas objek
require_once 'database.php';
require_once 'PendaftaranReguler.php';
require_once 'PendaftaranPrestasi.php';
require_once 'PendaftaranKedinasan.php';

// 1. Inisialisasi Koneksi Database
$db = new Database();

// 2. Mengambil Data Terkelompok Memanfaatkan Metode Query Spesifik (Versi Aman PDO)
$dataReguler   = PendaftaranReguler::getDaftarReguler($db);
$dataPrestasi  = PendaftaranPrestasi::getDaftarPrestasi($db);
$dataKedinasan = PendaftaranKedinasan::getDaftarKedinasan($db);

/**
 * Helper function untuk merender tabel data setiap jalur pendaftaran secara dinamis
 */
function renderTabelPMB($idSeksi, $judulJalur, $kumpulanData, $className, $ikonFasilitas) {
    echo "<div class='pmb-card $className' id='$idSeksi'>";
    echo "<div class='pmb-card-header'>";
    echo "<h3><i class='$ikonFasilitas'></i> Kategori: $judulJalur</h3>";
    echo "<span class='pmb-badge'>" . count($kumpulanData) . " Pendaftar</span>";
    echo "</div>";

    if (empty($kumpulanData)) {
        echo "<p class='pmb-empty'>Belum ada berkas pendaftaran yang masuk untuk jalur ini.</p>";
    } else {
        echo "<div class='pmb-table-responsive'>
                <table>
                    <thead>
                        <tr>
                            <th>ID Reg</th>
                            <th>Nama Lengkap</th>
                            <th>Asal Sekolah</th>
                            <th>Nilai Ujian</th>
                            <th>Biaya Dasar</th>
                            <th>Atribut Spesifik (Polimorfik)</th>
                            <th style='text-align: right;'>Total Biaya Akhir</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($kumpulanData as $mahasiswa) {
            echo "<tr>
                    <td class='id-text'>#{$mahasiswa->getIdPendaftaran()}</td>
                    <td><span class='candidate-name'>{$mahasiswa->getNamaCalon()}</span></td>
                    <td class='school-text'>{$mahasiswa->getAsalSekolah()}</td>
                    <td><span class='score-badge'>{$mahasiswa->getNilaiUjian()}</span></td>
                    <td class='text-muted'>Rp " . number_format($mahasiswa->getBiayaPendaftaranDasar(), 0, ',', '.') . "</td>
                    
                    <td><span class='info-unik'>{$mahasiswa->tampilkanInfoJalur()}</span></td>
                    
                    <td class='final-price'>Rp " . number_format($mahasiswa->hitungTotalBiaya(), 0, ',', '.') . "</td>
                  </tr>";
        }
        echo "</tbody></table></div>";
    }
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PMB - Final Interactive & Clean View</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Base Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            margin: 0;
            padding: 40px 20px;
        }
        .pmb-container {
            max-width: 1140px;
            margin: auto;
        }
        .pmb-main-header {
            text-align: center;
            margin-bottom: 35px;
        }
        .pmb-main-header h2 {
            color: #0f172a;
            margin: 0;
            font-size: 2.2rem;
            font-weight: 700;
        }
        .pmb-main-header p {
            color: #64748b;
            margin-top: 10px;
            font-size: 1.05rem;
        }

        /* --- CONTROLLER FILTER (FIXED: Dipaksa berada di lapisan terdepan) --- */
        .filter-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 99; /* Z-Index Tinggi agar tidak tertutup gradasi card */
        }
        .filter-container {
            background: #ffffff;
            padding: 6px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, 0.06);
            display: inline-flex;
            gap: 4px;
            border: 1px solid #e2e8f0;
            position: relative;
        }
        .filter-btn {
            background: transparent;
            border: none;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #64748b;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .filter-btn:hover {
            color: #0f172a;
            background-color: #f8fafc;
        }
        .filter-btn.active {
            background-color: #0f172a;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        /* --- DATA CARD LAYOUT --- */
        .pmb-card {
            background: #ffffff;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            margin-bottom: 35px;
            border: 1px solid #e2e8f0;
            position: relative;
            z-index: 1; /* Diatur rendah agar di bawah posisi filter dropdown/tab */
            transition: opacity 0.3s ease, transform 0.3s ease;
            opacity: 1;
            transform: scale(1);
        }
        
        /* Animasi Transisi Menyembunyikan Elemen */
        .pmb-card.hide {
            opacity: 0;
            transform: scale(0.97);
        }

        .pmb-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; }
        .pmb-card-header h3 { margin: 0; font-size: 1.35rem; font-weight: 700; display: flex; align-items: center; }
        .pmb-badge { font-size: 0.85rem; padding: 6px 14px; border-radius: 30px; font-weight: 700; }

        /* Tabel Data */
        .pmb-table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 14px; color: #475569; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
        td { padding: 16px 14px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; }
        tr:last-child td { border-bottom: none; }
        
        .id-text { color: #94a3b8; font-weight: 500; }
        .candidate-name { font-weight: 600; color: #0f172a; }
        .school-text { color: #475569; }
        .text-muted { color: #64748b; }
        .pmb-empty { color: #94a3b8; font-style: italic; text-align: center; padding: 20px; }
        
        .score-badge { background: #f8fafc; padding: 4px 8px; border-radius: 6px; font-weight: 600; color: #334155; border: 1px solid #e2e8f0; }
        .info-unik { font-size: 0.9rem; font-weight: 500; padding: 6px 12px; border-radius: 8px; display: inline-block; }
        .final-price { font-weight: 700; text-align: right; font-size: 1.05rem; }

        /* --- KONTRAS IDENTITAS JALUR (CLEAN DESIGN) --- */
        /* 1. Jalur Reguler (Teal) */
        .jalur-theme-reguler { border-top: 5px solid #0d9488; background: linear-gradient(to bottom, #f0fdfa, #ffffff 130px); }
        .jalur-theme-reguler h3 { color: #115e59; }
        .jalur-theme-reguler h3 i { color: #0d9488; margin-right: 10px; }
        .jalur-theme-reguler .pmb-badge { background: #ccfbf1; color: #115e59; }
        .jalur-theme-reguler th { background: #e6f6f4; }
        .jalur-theme-reguler tr:hover td { background-color: #f2fbf9; }
        .jalur-theme-reguler .info-unik { background: #f0fdfa; color: #115e59; border: 1px solid #99f6e4; }
        .jalur-theme-reguler .final-price { color: #0d9488; }

        /* 2. Jalur Prestasi (Indigo) */
        .jalur-theme-prestasi { border-top: 5px solid #4f46e5; background: linear-gradient(to bottom, #eef2ff, #ffffff 130px); }
        .jalur-theme-prestasi h3 { color: #3730a3; }
        .jalur-theme-prestasi h3 i { color: #4f46e5; margin-right: 10px; }
        .jalur-theme-prestasi .pmb-badge { background: #e0e7ff; color: #3730a3; }
        .jalur-theme-prestasi th { background: #eef1ff; }
        .jalur-theme-prestasi tr:hover td { background-color: #f5f7ff; }
        .jalur-theme-prestasi .info-unik { background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; }
        .jalur-theme-prestasi .final-price { color: #4f46e5; }

        /* 3. Jalur Kedinasan (Amber) */
        .jalur-theme-kedinasan { border-top: 5px solid #d97706; background: linear-gradient(to bottom, #fffbeb, #ffffff 130px); }
        .jalur-theme-kedinasan h3 { color: #92400e; }
        .jalur-theme-kedinasan h3 i { color: #d97706; margin-right: 10px; }
        .jalur-theme-kedinasan .pmb-badge { background: #fef3c7; color: #92400e; }
        .jalur-theme-kedinasan th { background: #fdf6e2; }
        .jalur-theme-kedinasan tr:hover td { background-color: #fffdf5; }
        .jalur-theme-kedinasan .info-unik { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .jalur-theme-kedinasan .final-price { color: #d97706; }
    </style>
</head>
<body>

<div class="pmb-container">
    <div class="pmb-main-header">
        <h2>Sistem Informasi Pendaftaran Mahasiswa Baru</h2>
        <p>Laporan Berkas Masuk Menggunakan Arsitektur OOP Polimorfisme Dinamis</p>
    </div>

    <div class="filter-wrapper">
        <div class="filter-container">
            <button class="filter-btn active" onclick="filterJalur('all', this)">
                <i class="fa-solid fa-border-all"></i> Tampilkan Semua
            </button>
            <button class="filter-btn" onclick="filterJalur('seksi-reguler', this)">
                <i class="fa-solid fa-graduation-cap"></i> Reguler
            </button>
            <button class="filter-btn" onclick="filterJalur('seksi-prestasi', this)">
                <i class="fa-solid fa-trophy"></i> Prestasi
            </button>
            <button class="filter-btn" onclick="filterJalur('seksi-kedinasan', this)">
                <i class="fa-solid fa-building-shield"></i> Kedinasan
            </button>
        </div>
    </div>

    <?php
        // Merender Tabel Kelompok Data (Nama Jalur Bersih & Rapi)
        renderTabelPMB("seksi-reguler", "Jalur Reguler", $dataReguler, "jalur-theme-reguler", "fa-solid fa-graduation-cap");
        renderTabelPMB("seksi-prestasi", "Jalur Prestasi", $dataPrestasi, "jalur-theme-prestasi", "fa-solid fa-trophy");
        renderTabelPMB("seksi-kedinasan", "Jalur Kedinasan", $dataKedinasan, "jalur-theme-kedinasan", "fa-solid fa-building-shield");
    ?>
</div>

<script>
function filterJalur(targetId, elemenTombol) {
    // 1. Reset tombol aktif
    const daftarTombol = document.querySelectorAll('.filter-btn');
    daftarTombol.forEach(btn => btn.classList.remove('active'));
    elemenTombol.classList.add('active');

    // 2. Filter kartu tabel kelompok
    const daftarKartu = document.querySelectorAll('.pmb-card');
    daftarKartu.forEach(kartu => {
        if (targetId === 'all') {
            kartu.style.display = 'block';
            setTimeout(() => kartu.classList.remove('hide'), 10);
        } else {
            if (kartu.id === targetId) {
                kartu.style.display = 'block';
                setTimeout(() => kartu.classList.remove('hide'), 10);
            } else {
                kartu.classList.add('hide');
                // Beri jeda transisi transparan sebelum mengubah display none
                setTimeout(() => { 
                    if(kartu.classList.contains('hide')) kartu.style.display = 'none'; 
                }, 250);
            }
        }
    });
}
</script>

</body>
</html>