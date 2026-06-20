<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_DIPROSES = 'diproses';
    public const STATUS_SIAP = 'siap';
    public const STATUS_SELESAI = 'selesai';
    public const STATUS_DIBATALKAN = 'dibatalkan';

    public const TIPE_DINE_IN = 'dine_in';
    public const TIPE_TAKEAWAY = 'takeaway';

    protected $fillable = [
        'user_id',
        'total_harga',
        'status_pesanan',
        'tipe_pesanan',
        'nomor_meja',
        'alamat_pengiriman',
        'metode_pembayaran',
        'payment_status',
        'catatan',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
