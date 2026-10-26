<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request; // ← Ditambahkan agar Request terbaca

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::query();

        // Opsional: Tambahkan pencarian nama anggota jika diperlukan
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%'.$request->query('nama').'%');
        }

        $members = $query->latest()->paginate(10);

        return MemberResource::collection($members);
    }

    public function show(string $id)
    {
        $member = Member::findOrFail($id);

        return new MemberResource($member);
    }
}