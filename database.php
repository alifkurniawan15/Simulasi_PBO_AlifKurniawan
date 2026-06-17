<?php

class Database {
    // Properti konfigurasi database (terenkapsulasi menggunakan private)
    private $host     = "localhost";
    private $username = "root";
    private $password = ""; 
    private $database = "db_simulasi_pbo_ti1c_alifkurniawan";
    
    // Properti public untuk menampung jembatan koneksi objek PDO
    public $conn;

    /**
     * Constructor: Otomatis dieksekusi saat objek dari class Database dibuat
     */
    public function __construct() {
        try {
            // Mendefinisikan Data Source Name (DSN) untuk MySQL
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=utf8mb4";
            
            // Menginisialisasi koneksi PDO
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Mengatur mode error PDO ke Exception untuk mempermudah debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $e) {
            // Menangkap galat jika koneksi gagal terbentuk
            die("Koneksi PDO ke database gagal: " . $e->getMessage());
        }
    }

    /**
     * Metode tambahan untuk memutus koneksi PDO secara eksplisit
     */
    public function tutupKoneksi() {
        $this->conn = null;
    }
}

?>