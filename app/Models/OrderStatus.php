<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['alias', 'name', 'default'];

    /**
     * @return mixed
     */
    public function scopeIsDefault()
    {
        return $this->where('default', true);
    }
}
