<?php
namespace App\Services\Instruksi;

use App\Models\Instruksi;

interface InstruksiServiceInterface
{
    public function getAllInstruksi($search=null, int $perPage=10, bool $eager=false);
    public function storeInstruksi(array $data):Instruksi;
    public function editInstruksi(Instruksi $instruksi, array $data):Instruksi;
    public function deleteInstruksi(Instruksi $instruksi):bool;
}