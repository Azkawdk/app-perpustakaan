<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ← Ditambahkan untuk Database Transaction

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['member', 'user', 'loanItems.book'])->latest()->paginate(10);

        return LoanResource::collection($loans);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|integer|exists:members,id',
            'user_id' => 'required|integer|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'book_ids' => 'required|array|min:1',
            'book_ids.*' => 'integer|exists:books,id',
        ], [
            'member_id.required' => 'Anggota wajib dipilih.',
            'user_id.required' => 'Petugas (user_id) wajib diisi.',
            'user_id.exists' => 'Petugas yang dipilih tidak valid.',
            'tanggal_pinjam.required' => 'Tanggal pinjam wajib diisi.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
            'book_ids.required' => 'Pilih minimal satu buku.',
            'book_ids.*.exists' => 'Salah satu buku yang dipilih tidak ditemukan.',
        ]);

        // Gunakan Transaction agar proses aman (All-or-Nothing)
        $loan = DB::transaction(function () use ($validated) {
            $loan = Loan::create([
                'member_id' => $validated['member_id'],
                'user_id' => $validated['user_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'dipinjam', // Pastikan kolom status ada di tabel loans
            ]);

            foreach ($validated['book_ids'] as $bookId) {
                // Buat item peminjaman
                $loan->loanItems()->create(['book_id' => $bookId]);

                // Kurangi stok buku
                $book = Book::lockForUpdate()->find($bookId);
                
                // Opsional: Validasi stok jika kosong
                if ($book->stok <= 0) {
                    throw new \Exception("Stok buku '{$book->judul}' habis.");
                }

                $book->decrement('stok');
            }

            return $loan;
        });

        $loan->load(['member', 'user', 'loanItems.book']);

        return (new LoanResource($loan))->response()->setStatusCode(201);
    }

    public function kembalikan(string $id)
    {
        $loan = Loan::with(['member', 'user', 'loanItems.book'])->findOrFail($id);

        // Cek jika sudah dikembalikan sebelumnya
        if (isset($loan->status) && $loan->status === 'dikembalikan') {
            return response()->json([
                'message' => 'Peminjaman ini sudah dikembalikan sebelumnya.'
            ], 422);
        }

        DB::transaction(function () use ($loan) {
            // Update status peminjaman
            $loan->update([
                'status' => 'dikembalikan',
                'tanggal_dikembalikan' => now()->toDateString(),
            ]);

            // Kembalikan stok buku
            foreach ($loan->loanItems as $item) {
                if ($item->book) {
                    $item->book->increment('stok');
                }
            }
        });

        return new LoanResource($loan);
    }
}