<?php

namespace Kelompok2\SistemTataTertib\Domain;

class KlasifikasiPelanggaran
{
    public int $id;
    public int $tingkat;
    public string $pelanggaran;
    public SanksiPelanggaran $sanksi;
}