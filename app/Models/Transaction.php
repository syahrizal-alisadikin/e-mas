<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    
    /**
     * posts
     *
     * @return void
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
