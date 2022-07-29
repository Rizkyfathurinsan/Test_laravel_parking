<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['plat_number', 'registration_number',
    'status', 'duration', 'category', 'created_by'];


    // public function customer(): BelongsTo
    // {
    //     return $this->belongsTo(Customer::class, 'customer_id', 'id');
    // }

    // public function category(): BelongsTo
    // {
    //     return $this->belongsTo(Category::class, 'category_id', 'id');
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public static function booted(){

        static::creating(function($model)
        {
            $model->created_by = auth()->id();
            $model->registration_number = rand(12,34353).time();
        });
    }
}
