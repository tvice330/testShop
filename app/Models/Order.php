<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_status_id', 'payment_status_id', 'count', 'total'
    ];

    protected $appends = ['format_date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_status()
    {
        return $this->belongsTo(PaymentStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order');
    }

    /**
     * @return string
     */
    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->created_at)->toDateString();
    }
}
