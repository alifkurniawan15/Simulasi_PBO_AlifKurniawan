<?php
require_once 'Pendaftaran.php';

class PendaftaranPrestasi extends Pendaftaran {
    // Properti tambahan terenkapsulasi (private)
    private $jenisPrestasi;
    private $tingkatPrestasi;

    // Constructor untuk memetakan data induk dan data spesifik prestasi
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $jenisPrestasi, $tingkatPrestasi) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->jenisPrestasi = $jenisPrestasi;
        $this->tingkatPrestasi = $tingkatPrestasi;
    }

    // Overriding Polimorfisme: Contoh Potongan Biaya 50% untuk Jalur Prestasi
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar * 0.50;
    }

    // Overriding Polimorfisme: Menampilkan fasilitas/informasi jalur prestasi
    public function tampilkanInfoJalur() {
        return "Prestasi: " . $this->jenisPrestasi . " (" . $this->tingkatPrestasi . ")";
    }

    /**
     * Metode Query Spesifik: Mengambil data yang hanya relevan dengan jalur Prestasi
     */
    public static function getDaftarPrestasi($db) {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Prestasi'";
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
                    $row['jenis_prestasi'], 
                    $row['tingkat_prestasi']
                );
            }
        }
        return $daftarObjek;
    }
}
?>