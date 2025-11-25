<?php

// --- 1. Pembalap Includes (Sudah Ada) ---
include_once("models/DB.php");
include_once("models/TabelPembalap.php");
include_once("views/ViewPembalap.php");
include_once("presenters/PresenterPembalap.php");

// --- 2. Tim Balap Includes (BARU) ---
include_once("models/TimBalap.php"); // Entity
include_once("models/TabelTimBalap.php"); // Model
include_once("views/ViewTimBalap.php"); // View
include_once("presenters/PresenterTimBalap.php"); // Presenter


// --- 3. Konfigurasi Database ---
$db_host = 'localhost';
$db_name = 'mvp_db';
$db_user = 'root';
$db_pass = '';
$content = ""; // Variabel untuk menyimpan output HTML


// --- 4. Inisialisasi Objek Pembalap ---
$tabelPembalap = new TabelPembalap($db_host, $db_name, $db_user, $db_pass);
$viewPembalap = new ViewPembalap();
$presenterPembalap = new PresenterPembalap($tabelPembalap, $viewPembalap);


// --- 5. Inisialisasi Objek Tim Balap (BARU) ---
$tabelTimBalap = new TabelTimBalap($db_host, $db_name, $db_user, $db_pass);
$viewTimBalap = new ViewTimBalap();
$presenterTimBalap = new PresenterTimBalap($tabelTimBalap, $viewTimBalap);


// --- 6. Logika Routing dan Aksi ---

// Cek aksi melalui GET (Menampilkan Form/List/Hapus)
if(isset($_GET['screen'])){
    $screen = $_GET['screen'];
    $id = $_GET['id'] ?? null;

    // --- Aksi Pembalap ---
    if($screen == 'add'){
        $content = $presenterPembalap->tampilkanFormPembalap();
    }
    else if($screen == 'edit'){
        // Perbaiki pemanggilan form edit agar membawa ID
        $content = $presenterPembalap->tampilkanFormPembalap($id);
    } 
    else if ($screen == 'delete_pembalap') {
        $presenterPembalap->hapusPembalap($id);
        header("Location: index.php");
        exit();
    }
    
    // --- Aksi Tim Balap (BARU) ---
    else if($screen == 'tim_list'){
        $content = $presenterTimBalap->tampilkanTim();
    }
    else if($screen == 'add_tim'){
        $content = $presenterTimBalap->tampilkanFormTim();
    }
    else if($screen == 'edit_tim'){
        $content = $presenterTimBalap->tampilkanFormTim($id);
    }
    else if($screen == 'delete_tim'){
        $presenterTimBalap->hapusTim($id);
        header("Location: index.php?screen=tim_list");
        exit();
    }

} 
// Cek aksi melalui POST (Menyimpan Data: Create/Update)
else if(isset($_POST['action'])){
    $action = $_POST['action'];

    // --- Aksi Pembalap ---
    if ($action == 'add_pembalap') {
        $presenterPembalap->tambahPembalap($_POST['nama'], $_POST['tim'], $_POST['negara'], $_POST['poinMusim'], $_POST['jumlahMenang']);
        header("Location: index.php");
        exit();
    } 
    else if ($action == 'update_pembalap') {
        $presenterPembalap->ubahPembalap($_POST['id'], $_POST['nama'], $_POST['tim'], $_POST['negara'], $_POST['poinMusim'], $_POST['jumlahMenang']);
        header("Location: index.php");
        exit();
    }
    
    // --- Aksi Tim Balap (BARU) ---
    else if ($action == 'add_tim') {
        $presenterTimBalap->tambahTim($_POST['nama'], $_POST['markas'], $_POST['tahunBerdiri']);
        header("Location: index.php?screen=tim_list");
        exit();
    } 
    else if ($action == 'update_tim') {
        $presenterTimBalap->ubahTim($_POST['id'], $_POST['nama'], $_POST['markas'], $_POST['tahunBerdiri']);
        header("Location: index.php?screen=tim_list");
        exit();
    }
    
    // Jika tidak ada aksi yang dikenali, kembali ke list utama
    header("Location: index.php");
    exit();

} else{
    // Default: Tampilkan Daftar Pembalap
    $content = $presenterPembalap->tampilkanPembalap();
}

// Menampilkan konten hasil Presenter
echo $content;

?>