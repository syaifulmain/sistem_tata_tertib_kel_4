<?php

namespace Kelompok2\SistemTataTertib\Service;

interface AdminService
{
    function getAllMahasiswa();

    function searchMahasiswaByNimOrName();

    function deleteMahasiswaByNim();

    function approveMahasiswaDataChange();

    function addRules();

    function updateRules();

    function deleteRules();

    function addMahasiswaViolation();

    function updateMahasiswaViolation();

    function deleteMahasiswaViolation();

    function verifyMahasiswaSanctionDocument();
}