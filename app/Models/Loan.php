<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 
        'user_id', 
        'tanggal_pinjam',
        'tanggal_kembali', 
        'tanggal_dikembalikan', 
        'status',
    ];
}