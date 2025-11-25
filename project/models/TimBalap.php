<?php
// models/TimBalap.php

class TimBalap {
    private $id;
    private $nama;
    private $markas;
    private $tahunBerdiri;

    public function __construct($id, $nama, $markas, $tahunBerdiri) {
        $this->id = $id;
        $this->nama = $nama;
        $this->markas = $markas;
        $this->tahunBerdiri = $tahunBerdiri;
    }

    // Getter
    public function getId() { return $this->id; }
    public function getNama() { return $this->nama; }
    public function getMarkas() { return $this->markas; }
    public function getTahunBerdiri() { return $this->tahunBerdiri; }
}

?>