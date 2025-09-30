<?php
namespace App\Repositories\Instruksi;
use App\Models\Instruksi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface InstruksiRepositoryInterface
{
    public function getAll(? string $search=null, int $perPage=10, bool $eager=false);
    public function storeInstruksi(array $data);

    public function editInstruksi(Instruksi $instruksi, array $data);

    public function deleteInstruksi(Instruksi $instruksi):bool;
    
}
