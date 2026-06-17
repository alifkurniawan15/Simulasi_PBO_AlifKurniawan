<?php

// Mendefinisikan class sebagai abstract class
abstract class Pendaftaran {
    // Properti terenkapsulasi (protected agar bisa diakses langsung oleh subclass/kelas anak)
    protected $id_pendaftaran;
    protected $nama_calon;
    protected $asal_sekolah;
    protected $nilai_ujian;
    protected $biayaPendaftaranDasar;

    /**
     * Constructor untuk memetakan data dari kolom tabel database
     */
    public function __construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar) {
        $this->id_pendaftaran        = $id_pendaftaran;
        $this->nama_calon            = $nama_calon;
        $this->asal_sekolah          = $asal_sekolah;
        $this->nilai_ujian           = $nilai_ujian;
        $this->biayaPendaftaranDasar = $biayaPendaftaranDasar;
    }

    /**
     * METODE ABSTRAK (Tanpa Isi / Body)
     * Wajib di-override dan diimplementasikan secara nyata di dalam kelas-kelas anak.
     */
    abstract public function hitungTotalBiaya();
    abstract public function tampilkanInfoJalur();

    // =========================================================================
    // GETTER METHODS (Untuk mengakses properti terenkapsulasi pada halaman View)
    // =========================================================================
    public function getIdPendaftaran() { return $this->id_pendaftaran; }
    public function getNamaCalon() { return $this->nama_calon; }
    public function getAsalSekolah() { return $this->asal_sekolah; }
    public function getNilaiUjian() { return $this->nilai_ujian; }
    public function getBiayaPendaftaranDasar() { return $this->biayaPendaftaranDasar; }
}

?>