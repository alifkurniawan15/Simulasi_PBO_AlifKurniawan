<?php
require_once 'Pendaftaran.php';

class PendaftaranKedinasan extends Pendaftaran {
    // Properti tambahan terenkapsulasi (private) - Dikunci skIkatanDinas
    private $skIkatanDinas;
    private $instansiSponsor;

    // Constructor untuk memetakan data induk dan data spesifik kedinasan
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar, $skIkatanDinas, $instansiSponsor) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->skIkatanDinas = $skIkatanDinas;
        $this->instansiSponsor = $instansiSponsor;
    }

    /**
     * Overriding Polimorfisme: Jalur Kedinasan
     * Total Biaya = Dikenakan surcharge tambahan sebesar 25%
     */
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar * 1.25;
    }

    // Overriding Polimorfisme: Menampilkan informasi jalur kedinasan
    public function tampilkanInfoJalur() {
        return "Sponsor: " . $this->instansiSponsor . " | No SK: " . $this->skIkatanDinas;
    }

    /**
     * Metode Query Spesifik: Mengambil data Jalur Kedinasan
     */
public static function getDaftarKedinasan($db) {
        $sql = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Kedinasan'";
        $result = $db->conn->query($sql);
        
        $daftarObjek = [];
        // FIX PDO
        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $daftarObjek[] = new self(
                    $row['id_pendaftaran'], 
                    $row['nama_calon'], 
                    $row['asal_sekolah'], 
                    $row['nilai_ujian'], 
                    $row['biaya_pendaftaran_dasar'],
                    $row['sk_ikatan_dinas'], 
                    $row['instansi_sponsor']
                );
            }
        }
        return $daftarObjek;
    }
}
?>