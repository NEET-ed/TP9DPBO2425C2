<?php
// presenters/PresenterTimBalap.php

include_once(__DIR__ . "/KontrakPresenter.php");
include_once(__DIR__ . "/../models/TabelTimBalap.php");
include_once(__DIR__ . "/../models/TimBalap.php");
include_once(__DIR__ . "/../views/ViewTimBalap.php");

class PresenterTimBalap implements KontrakPresenter{
    private $tabelTimBalap; 
    private $viewTimBalap; 
    private $listTimBalap = []; 

    public function __construct($tabelTimBalap, $viewTimBalap){
        $this->tabelTimBalap = $tabelTimBalap;
        $this->viewTimBalap = $viewTimBalap;
        $this->tabelTimBalap->open(); 
        $this->initListTimBalap();
    }
    
    // --- Implementasi dummy untuk metode Pembalap (sesuai KontrakPresenter) ---
    public function tampilkanPembalap(): string { return ""; }
    public function tampilkanFormPembalap($id = null): string { return ""; }
    public function tambahPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {}
    public function ubahPembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {}
    public function hapusPembalap($id): void {}

    // --- Implementasi Metode Tim Balap ---

    // Inisialisasi list tim balap dari database
    public function initListTimBalap(){
        // Menggunakan method dari TabelTimBalap yang mengimplementasikan KontrakModel
        $data = $this->tabelTimBalap->getAllTim(); 

        $this->listTimBalap = [];
        foreach ($data as $item) {
            $tim = new TimBalap(
                $item['id'],
                $item['nama'],
                $item['markas'],
                $item['tahunBerdiri']
            );
            $this->listTimBalap[] = $tim;
        }
    }

    // Read List
    public function tampilkanTim(): string{
        return $this->viewTimBalap->tampilTim($this->listTimBalap);
    }

    // Read for Update / Form Create
    public function tampilkanFormTim($id = null): string{
        $data = null;
        if ($id !== null) {
            $data = $this->tabelTimBalap->getTimById($id);
        }
        return $this->viewTimBalap->tampilFormTim($data);
    }

    // CREATE
    public function tambahTim($nama, $markas, $tahunBerdiri): void {
        $this->tabelTimBalap->addTim($nama, $markas, $tahunBerdiri);
        $this->initListTimBalap(); 
    }
    
    // UPDATE
    public function ubahTim($id, $nama, $markas, $tahunBerdiri): void {
        $this->tabelTimBalap->updateTim($id, $nama, $markas, $tahunBerdiri);
        $this->initListTimBalap();
    }
    
    // DELETE
    public function hapusTim($id): void {
        $this->tabelTimBalap->deleteTim($id);
        $this->initListTimBalap();
    }

    public function __destruct() {
        // Asumsi TabelTimBalap mewarisi method close() dari DB
        $this->tabelTimBalap->close();
    }
}

?>