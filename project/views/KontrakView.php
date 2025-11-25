<?php

interface KontrakView
{
    public function tampilPembalap($listPembalap): string;
    public function tampilFormPembalap($data = null): string;

    // --- Metode Tim Balap (BARU) ---
    public function tampilTim($listTimBalap): string;
    public function tampilFormTim($data = null): string;
}

?>