<?php
namespace App\Services\Instruksi;
use App\Repositories\Instruksi\InstruksiRepositoryInterface;
use App\Models\Instruksi;

class InstruksiService implements InstruksiServiceInterface{
    protected InstruksiRepositoryInterface $instruksiRepository;

    public function __construct(InstruksiRepositoryInterface $instruksiRepository) {
        $this->instruksiRepository=$instruksiRepository;
    }


    public function getAllInstruksi($search = null, int $perPage = 10, bool $eager = false){
        return $this->instruksiRepository->getAll($search, $perPage, $eager);
    }

    public function storeInstruksi(array $data): Instruksi
    {
        return $this->instruksiRepository->storeInstruksi($data);
    }

    public function editInstruksi(Instruksi $instruksi, array $data): Instruksi
    {
        return $this->instruksiRepository->editInstruksi($instruksi, $data);
    }

    public function deleteInstruksi(Instruksi $instruksi): bool
    {
        return $this->instruksiRepository->deleteInstruksi($instruksi);
    }

}
