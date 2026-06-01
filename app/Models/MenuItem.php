<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image_path',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? asset('storage/'.$this->image_path) : asset('images/default-menu.png');
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'menu_item_promo');
    }
}
