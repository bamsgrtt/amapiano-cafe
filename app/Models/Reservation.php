<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'fullname',
        'phone',
        'date',
        'time',
        'area',
        'table_id',
        'guests',
        'notes',
        'status',
        'checked_in_at',
    ];

    /**
     * The "boot" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reservation) {
            if (empty($reservation->code)) {
                $reservation->code = self::generateUniqueCode();
            }
        });
    }

    /**
     * Generate a unique reservation code in format AMP-XXXX.
     */
    public static function generateUniqueCode(): string
    {
        do {
            $code = 'AMP-' . str_pad((string) rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
