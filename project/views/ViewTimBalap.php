<?php
// views/ViewTimBalap.php

include_once(__DIR__ . "/KontrakView.php");
include_once(__DIR__ . "/../models/TimBalap.php");

class ViewTimBalap implements KontrakView {
    
    // Implementasi dummy untuk metode Pembalap (sesuai KontrakView)
    // Dalam implementasi nyata, view ini hanya fokus pada Tim Balap,
    // tetapi kontrak mengharuskan semua metode diisi.
    public function tampilPembalap($listPembalap): string { return ""; }
    public function tampilFormPembalap($data = null): string { return ""; }


    // --- Implementasi Metode Tim Balap ---

    // Method untuk menampilkan daftar tim (List/Read)
    public function tampilTim($listTimBalap): string {
        $dataHtml = '';
        foreach ($listTimBalap as $tim) {
            /* @var TimBalap $tim */
            $dataHtml .= '<tr>';
            $dataHtml .= '<td>' . $tim->getNama() . '</td>';
            $dataHtml .= '<td>' . $tim->getMarkas() . '</td>';
            $dataHtml .= '<td>' . $tim->getTahunBerdiri() . '</td>';
            $dataHtml .= '<td>
                            <a href="index.php?aksi=edit_tim&id=' . $tim->getId() . '" class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?aksi=hapus_tim&id=' . $tim->getId() . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin hapus data ini?\')">Hapus</a>
                          </td>';
            $dataHtml .= '</tr>';
        }

        $header = '<h2>Daftar Tim Balap</h2><a href="index.php?aksi=add_tim" class="btn btn-success mb-3">Tambah Tim</a>';
        $table = '
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Tim</th>
                        <th>Markas</th>
                        <th>Tahun Berdiri</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>' . $dataHtml . '</tbody>
            </table>';

        // Ini hanya contoh tampilan, sesuaikan dengan template/skin utama Anda
        return $header . $table;
    }

    // Method untuk menampilkan form tambah/edit (Create/Update Form)
    public function tampilFormTim($data = null): string {
        $isEdit = $data !== null;
        $title = $isEdit ? "Edit Tim Balap" : "Tambah Tim Balap";
        $actionUrl = $isEdit ? "aksi=update_tim&id=" . $data['id'] : "aksi=tambah_tim_db";

        // Nilai awal untuk prefill form
        $id = $isEdit ? $data['id'] : '';
        $nama = $isEdit ? $data['nama'] : '';
        $markas = $isEdit ? $data['markas'] : '';
        $tahunBerdiri = $isEdit ? $data['tahunBerdiri'] : '';
        
        $html = "
            <h2>$title</h2>
            <form action='index.php?$actionUrl' method='POST'>
                " . ($isEdit ? "<input type='hidden' name='id' value='$id'>" : "") . "
                <div class='mb-3'>
                    <label for='nama' class='form-label'>Nama Tim</label>
                    <input type='text' class='form-control' id='nama' name='nama' value='$nama' required>
                </div>
                <div class='mb-3'>
                    <label for='markas' class='form-label'>Markas</label>
                    <input type='text' class='form-control' id='markas' name='markas' value='$markas' required>
                </div>
                <div class='mb-3'>
                    <label for='tahunBerdiri' class='form-label'>Tahun Berdiri</label>
                    <input type='number' class='form-control' id='tahunBerdiri' name='tahunBerdiri' value='$tahunBerdiri' required>
                </div>
                <button type='submit' class='btn btn-primary'>" . ($isEdit ? "Update" : "Simpan") . "</button>
                <a href='index.php?aksi=tim_list' class='btn btn-secondary'>Batal</a>
            </form>
        ";
        
        return $html;
    }
}

?>