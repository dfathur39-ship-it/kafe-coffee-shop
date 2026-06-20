<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const STOK_TERSEDIA = 'tersedia';
    public const STOK_HABIS = 'habis';

    protected $fillable = [
        'category_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'foto',
        'stok_status',
        'is_featured',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isAvailable(): bool
    {
        return $this->stok_status === self::STOK_TERSEDIA;
    }

    public function getFotoUrlAttribute(): ?string
    {
        if (blank($this->foto)) {
            return null;
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        return asset('storage/'.$this->foto);
    }
}
