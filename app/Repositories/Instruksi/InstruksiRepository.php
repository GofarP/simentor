<?php
namespace App\Repositories\Instruksi;
use App\Models\Instruksi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class InstruksiRepository implements InstruksiRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = Instruksi::query()->with(['pengirim', 'penerima']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('pengirim', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%$search%");
                })
                ->orWhereHas('penerima', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%$search%");
                })
                ->orWhere('judul', 'like', "%$search%")
                ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        $query->orderByDesc('created_at');

        return $eager
            ? $query->get()
            : $query->paginate($perPage)->onEachSide(1);
    }

    public function storeInstruksi(array $data)
    {
        return Instruksi::create($data);
    }

    public function editInstruksi(Instruksi $instruksi, array $data)
    {
        $instruksi->update($data);
        return $instruksi;
    }


    public function deleteInstruksi(Instruksi $instruksi): bool
    {
        return $instruksi->delete();
    }


}