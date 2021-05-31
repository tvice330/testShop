<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class LikeReview extends Model
{
    protected $fillable = ['user_id', 'review_id', 'like'];

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
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
