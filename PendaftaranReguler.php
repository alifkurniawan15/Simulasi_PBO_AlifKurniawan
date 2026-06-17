<?php
require_once 'Pendaftaran.php';

class PendaftaranReguler extends Pendaftaran {
    // Properti tambahan terenkapsulasi (private)
    private $pilihanProdi;
    private $lokasiKampus;

    // Constructor untuk memetakan data induk dan data spesifik reguler
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $pilihanProdi, $lokasiKampus) {
        // Melempar parameter utama ke constructor abstract class Pendaftaran
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->pilihanProdi = $pilihanProdi;
        $this->lokasiKampus = $lokasiKampus;
    }

    // Overriding Polimorfisme: Jalur Reguler (Total Biaya = Biaya Dasar)
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar;
    }

    // Overriding Polimorfisme: Menampilkan fasilitas/informasi jalur reguler
    public function tampilkanInfoJalur() {
        return "Prodi: " . $this->pilihanProdi . " | Kampus: " . $this->lokasiKampus;
    }

    /**
     * Metode Query Spesifik: Mengambil data yang hanya relevan dengan jalur Reguler
     */
    public static function getDaftarReguler($db) {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Reguler'";
        $result = $db->conn->query($sql);
        
        $daftarObjek = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $daftarObjek[] = new self(
                    $row['id_pendaftaran'], 
                    $row['nama_calon'], 
                    $row['asal_sekolah'], 
                    $row['nilai_ujian'], 
                    $row['biaya_pendaftaran_dasar'],
                    $row['pilihan_prodi'], 
                    $row['lokasi_kampus'] // Sesuaikan nama kolom database Anda
                );
            }
        }
        return $daftarObjek;
    }
}
?>