<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Jika nama tabel di migration kamu bukan 'categories', 
    // aktifkan baris di bawah ini dan sesuaikan namanya:
    // protected $table = 'nama_tabel_kategori_kamu';

    protected $fillable = [
        'name',
    ];
}