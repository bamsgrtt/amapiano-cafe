<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOperationalDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'is_open',
    ];

    protected $casts = [
        'date' => 'date',
        'is_open' => 'boolean',
    ];

    public function getStatusLabelAttribute(): string
    {
        return $this->is_open ? 'Buka' : 'Tutup';
    }
}
