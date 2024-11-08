<?php

namespace Kelompok2\SistemTataTertib\Service;

use Kelompok2\SistemTataTertib\Model\Mahasiswa\MahasiswaDataResponse;

interface MahasiswaService
{
    function updateMahasiswa();

    function getMahasiswa(String $nim) : MahasiswaDataResponse;

    function uploadSanctionDocument();
}