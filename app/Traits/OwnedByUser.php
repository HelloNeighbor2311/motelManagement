<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait OwnedByUser
{
    public static function bootOwnedByUser()
    {
        static::creating(function ($model) {
            if (empty($model->user_id) && Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function scopeForCurrentUser(Builder $query)
    {
        if (Auth::check()) {
            return $query->where('user_id', Auth::id());
        }

        return $query->whereNull('user_id');
    }

    public function scopeOwnedBy(Builder $query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
