<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_no',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'shipping_address',
        'shipping_name',
        'shipping_phone',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate invoice number otomatis, contoh: INV-20260812-0001
    public static function generateInvoiceNo(): string
    {
        $prefix = 'INV-' . now()->format('Ymd') . '-';
        $lastOrder = static::where('invoice_no', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $lastNumber = $lastOrder
            ? (int) substr($lastOrder->invoice_no, -4)
            : 0;

        return $prefix . str_pad((string) ($lastNumber + 1), 4, '0', STR_PAD_LEFT);
    }
}
