<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{

    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_country',
        'shipping_zip',
        'shipping_cost',
        'tax',
        'total',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax'           => 'decimal:2',
        'total'         => 'decimal:2',
    ];


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }


    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    public function getNameAttribute(): string
    {
        return $this->customer_name ?? '';
    }


    public function getEmailAttribute(): string
    {
        return $this->customer_email ?? '';
    }


    public function getPhoneAttribute(): ?string
    {
        return $this->customer_phone;
    }


    public function getAddressAttribute(): string
    {
        return $this->shipping_address ?? '';
    }


    public function getCityAttribute(): string
    {
        return $this->shipping_city ?? '';
    }


    public function getCountryAttribute(): string
    {
        return $this->shipping_country ?? '';
    }


    public function getZipCodeAttribute(): ?string
    {
        return $this->shipping_zip;
    }


    public function getSubtotalAttribute(): float
    {
        return round((float)$this->total - (float)$this->shipping_cost - (float)$this->tax, 2);
    }


    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'yellow',
            'processing' => 'blue',
            'shipped'    => 'purple',
            'delivered'  => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }


    public static function generateOrderNumber(): string
    {
        return 'DP-' . date('Y') . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT);
    }
}
