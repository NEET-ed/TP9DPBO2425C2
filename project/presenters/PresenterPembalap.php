<?php

include_once(__DIR__ . "/KontrakPresenter.php");
include_once(__DIR__ . "/../models/TabelPembalap.php");
include_once(__DIR__ . "/../models/Pembalap.php");
include_once(__DIR__ . "/../views/ViewPembalap.php");

class PresenterPembalap implements KontrakPresenter{
    // Model PembalapQuery untuk operasi database
    private $tabelPembalap; // Instance dari TabelPembalap (Model)
    private $viewPembalap; // Instance dari ViewPembalap (View)

    // Data list pembalap
    private $listPembalap = []; // Menyimpan array objek Pembalap

    public function __construct($tabelPembalap, $viewPembalap){
        $this->tabelPembalap = $tabelPembalap;
        $this->viewPembalap = $viewPembalap;
        // Inisialisasi koneksi database sebelum memuat data
        $this->tabelPembalap->open(); 
        $this->initListPembalap();
    }

    //// dummies
    
    public function tampilkanTim(): string{ return ""; }
    public function tampilkanFormTim($id = null): string{ return ""; }
    public function tambahTim($nama, $markas, $tahunBerdiri): void{}
    public function ubahTim($id, $nama, $markas, $tahunBerdiri): void{}
    public function hapusTim($id): void{}
    // dummies
    // Method untuk initialisasi list pembalap dari database
    public function initListPembalap(){
        // Dapatkan data pembalap dari database (dalam bentuk array assosiatif)
        $data = $this->tabelPembalap->getAllPembalap();

        // Buat objek Pembalap dan simpan di listPembalap (Transformasi data Model ke objek Presenter/View)
        $this->listPembalap = [];
        foreach ($data as $item) {
            $pembalap = new Pembalap(
                $item['id'],
                $item['nama'],
                $item['tim'],
                $item['negara'],
                $item['poinMusim'],
                $item['jumlahMenang']
            );
            $this->listPembalap[] = $pembalap;
        }
    }

    // Method untuk menampilkan daftar pembalap menggunakan View
    public function tampilkanPembalap(): string{
        return $this->viewPembalap->tampilPembalap($this->listPembalap);
    }

    // Method untuk menampilkan form
    public function tampilkanFormPembalap($id = null): string{
        $data = null;
        if ($id !== null) {
            // Ambil data dari Model untuk diisi di form (mode edit)
            $data = $this->tabelPembalap->getPembalapById($id); 
        }
        return $this->viewPembalap->tampilFormPembalap($data);
    }

    // --- Implementasi Metode CRUD ---

    /**
     * Menambahkan data pembalap baru melalui Model.
     * Setelah berhasil, data di-refresh.
     */
    public function tambahPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        // Memanggil method addPembalap di Model
        $this->tabelPembalap->addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang);
        
        // Refresh data setelah penambahan berhasil
        $this->initListPembalap(); 
    }
    
    /**
     * Memperbarui data pembalap yang sudah ada melalui Model.
     * Setelah berhasil, data di-refresh.
     */
    public function ubahPembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        // Memanggil method updatePembalap di Model
        $this->tabelPembalap->updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang);
        
        // Refresh data setelah perubahan berhasil
        $this->initListPembalap();
    }
    
    /**
     * Menghapus data pembalap melalui Model.
     * Setelah berhasil, data di-refresh.
     */
    public function hapusPembalap($id): void {
        // Memanggil method deletePembalap di Model
        $this->tabelPembalap->deletePembalap($id);
        
        // Refresh data setelah penghapusan berhasil
        $this->initListPembalap();
    }

    // Pastikan koneksi ditutup saat objek Presenter dihancurkan
    public function __destruct() {
        $this->tabelPembalap->close();
    }
}

?>