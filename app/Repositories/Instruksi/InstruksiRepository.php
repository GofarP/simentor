<?php

namespace App\Repositories\Instruksi;

use App\Models\Instruksi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class InstruksiRepository implements InstruksiRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = Instruksi::with(['pengirim', 'penerima']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // cari di nama pengirim
                $q->orWhereHas('pengirim', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                });

                // cari di nama penerima
                $q->orWhereHas('penerima', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                });

                // cari di field instruksi langsung
                $q->orWhere('judul', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $query->orderByDesc('created_at');

        return $eager
            ? $query->get()
            : $query->paginate($perPage)->onEachSide(1);
    }


    public function storeInstruksi(array $data)
    {
        if (request()->hasFile('lampiran')) {
            $data['lampiran'] = request()->file('lampiran')->store('lampiran', 'public');
        }
        $data['pengirim_id'] = Auth::user()->id;
        return Instruksi::create($data);
    }

    public function editInstruksi(Instruksi $instruksi, array $data)
    {
        if (request()->hasFile('lampiran')) {
            if ($instruksi->lampiran && Storage::disk('public')->exists($instruksi->lampiran)) {
                Storage::disk('public')->delete($instruksi->lampiran);
            }
            $data['lampiran'] = request()->file('lampiran')->store('lampiran', 'public');
        }

        $instruksi->update($data);

        return $instruksi;
    }


    public function deleteInstruksi(Instruksi $instruksi): bool
    {
        if ($instruksi->lampiran && Storage::disk('public')->exists($instruksi->lampiran)) {
            Storage::disk('public')->delete($instruksi->lampiran);
        }

        return $instruksi->delete();
    }
}
