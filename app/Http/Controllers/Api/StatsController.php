<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;

class StatsController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Statistik berhasil dimuat',
            'data' => [
                'total_buku' => Book::count(),
                'total_anggota' => Member::count(),
                'peminjaman_aktif' => Loan::where('status', 'dipinjam')->count(),
            ]
        ], 200);
    }
}