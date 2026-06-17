<?php
require_once 'Pendaftaran.php';

class PendaftaranKedinasan extends Pendaftaran {
    // Properti tambahan terenkapsulasi (private) - Menggunakan skIkatanDinas
    private $skIkatanDinas;
    private $instansiSponsor;

    // Constructor untuk memetakan data induk dan data spesifik kedinasan
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $skIkatanDinas, $instansiSponsor) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->skIkatanDinas = $skIkatanDinas;
        $this->instansiSponsor = $instansiSponsor;
    }

    // Overriding Polimorfisme: Contoh Jalur Kedinasan Gratis / Biaya 0 karena Ditanggung Sponsor
    public function hitungTotalBiaya() {
        return 0;
    }

    // Overriding Polimorfisme: Menampilkan fasilitas/informasi jalur kedinasan
    public function tampilkanInfoJalur() {
        return "Sponsor: " . $this->instansiSponsor . " | No SK: " . $this->skIkatanDinas;
    }

    /**
     * Metode Query Spesifik: Mengambil data yang hanya relevan dengan jalur Kedinasan
     */
    public static function getDaftarKedinasan($db) {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Kedinasan'";
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
                    $row['sk_ikatan_dinas'], // Mengambil data kolom asli dari MySQL
                    $row['instansi_sponsor']
                );
            }
        }
        return $daftarObjek;
    }
}
?>