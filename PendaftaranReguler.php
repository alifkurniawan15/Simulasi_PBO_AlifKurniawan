<?php
require_once 'Pendaftaran.php';

class PendaftaranReguler extends Pendaftaran {
    // Properti tambahan terenkapsulasi (private)
    private $pilihanProdi;
    private $lokasiKampus;

    // Constructor untuk memetakan data induk dan data spesifik reguler
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $pilihanProdi, $lokasiKampus) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->pilihanProdi = $pilihanProdi;
        $this->lokasiKampus = $lokasiKampus;
    }

    /**
     * Overriding Polimorfisme: Jalur Reguler
     * Total Biaya = Tarif standar murni tanpa biaya tambahan
     */
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar;
    }

    // Overriding Polimorfisme: Menampilkan informasi jalur reguler
    public function tampilkanInfoJalur() {
        return "Prodi: " . $this->pilihanProdi . " | Kampus: " . $this->lokasiKampus;
    }

    /**
     * Metode Query Spesifik: Mengambil data Jalur Reguler
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
                    $row['lokasi_kampus']
                );
            }
        }
        return $daftarObjek;
    }
}
?>