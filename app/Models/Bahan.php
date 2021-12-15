<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahan extends Model
{
    use HasFactory;
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
    public function modal()
    {
        return $this->belongsToMany(Modal::class);
    }
}
