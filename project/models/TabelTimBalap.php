<?php
// models/TabelTimBalap.php

include_once (__DIR__ . "/DB.php");
include_once (__DIR__ . "/../models/KontrakModel.php"); // Menggunakan kontrak yang sudah diperbarui

class TabelTimBalap extends DB implements KontrakModel {

    // Konstruktor dan inisialisasi koneksi seperti di TabelPembalap
    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // Implementasi dummy untuk metode Pembalap (sesuai KontrakModel)
    // Dalam implementasi nyata, model ini hanya fokus pada Tim Balap, 
    // tetapi kontrak mengharuskan semua metode diisi. Kita arahkan ke model yang benar.
    // Jika Anda ingin memisahkan kontrak per entitas, hapus bagian ini.
    // **ASUMSI: KontrakModel harus dipecah per entitas atau TabelTimBalap fokus ke metode Tim saja.**
    // **Kita anggap KontrakModel HARUS diimplementasi penuh.**
    
    public function getAllPembalap(): array { return []; } 
    public function getPembalapById($id): ?array { return null; }
    public function addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {}
    public function updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {}
    public function deletePembalap($id): void {}


    // --- Implementasi Metode Tim Balap ---

    // READ: Mendapatkan semua tim balap
    public function getAllTim(): array {
        $query = "SELECT * FROM tim_balap";
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    // READ: Mendapatkan tim balap berdasarkan ID
    public function getTimById($id): ?array {
        $this->executeQuery("SELECT * FROM tim_balap WHERE id = :id", ['id' => $id]);
        $results = $this->getAllResult();
        return $results[0] ?? null;
    }

    // CREATE: Menambahkan tim balap baru
    public function addTim($nama, $markas, $tahunBerdiri): void {
        $query = "INSERT INTO tim_balap (nama, markas, tahunBerdiri) 
                  VALUES (:nama, :markas, :tahunBerdiri)";
        
        $params = [
            'nama' => $nama,
            'markas' => $markas,
            'tahunBerdiri' => $tahunBerdiri
        ];

        $this->executeQuery($query, $params);
    }
    
    // UPDATE: Memperbarui data tim balap
    public function updateTim($id, $nama, $markas, $tahunBerdiri): void {
        $query = "UPDATE tim_balap SET 
                    nama = :nama, 
                    markas = :markas, 
                    tahunBerdiri = :tahunBerdiri
                  WHERE id = :id";
        
        $params = [
            'id' => $id,
            'nama' => $nama,
            'markas' => $markas,
            'tahunBerdiri' => $tahunBerdiri
        ];

        $this->executeQuery($query, $params);
    }
    
    // DELETE: Menghapus data tim balap
    public function deleteTim($id): void {
        $query = "DELETE FROM tim_balap WHERE id = :id";
        $params = ['id' => $id];

        $this->executeQuery($query, $params);
    }
}

?>