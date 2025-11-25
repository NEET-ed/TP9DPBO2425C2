<?php

class DB{

    private $host = "localhost";
    private $db_name = "";
    private $username = "";
    private $password = "";
    
    private $conn;
    private $result;

    // Constructor untuk inisialisasi database
    function __construct($host, $db_name, $username, $password) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        // KONEKSI DIBUAT SAAT OBJEK DIINSTANSIASI
        $this->conn = $this->connect(); 
    }

    // Method untuk membuat koneksi database
    public function connect() {
        // ... (Kode connect() tetap sama) ...
        $conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $exception) {
            throw new RuntimeException("Koneksi gagal: " . $exception->getMessage(), 0, $exception);
        }
        return $conn;
    }

    /**
     * @inheritDoc
     * Method BARU: Dipanggil oleh Presenter untuk membuka koneksi.
     * Karena koneksi sudah dibuat di __construct, kita bisa gunakan ini 
     * untuk memastikan koneksi ada.
     */
    public function open() {
        if ($this->conn === null) {
            $this->conn = $this->connect();
        }
    }
    
    // Method untuk mengeksekusi query dengan prepared statement
    public function executeQuery($query, $params = []) {
        // ... (Kode executeQuery() tetap sama) ...
        // Pastikan koneksi sudah ada
        if ($this->conn === null) {
            throw new RuntimeException('No database connection. Make sure connect() succeeded.');
        }

        // Eksekusi query dengan prepared statement dengan penanganan error
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            $this->result = $stmt;
            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException('Query gagal: ' . $e->getMessage(), 0, $e);
        }
    }

    // Mengambil semua hasil dari query sebagai array asosiatif
    public function getAllResult() {
        // ... (Kode getAllResult() tetap sama) ...
        if ($this->result === null) {
            return [];
        }
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method untuk menutup koneksi database
    public function close() {
        $this->conn = null;
    }

}

?>