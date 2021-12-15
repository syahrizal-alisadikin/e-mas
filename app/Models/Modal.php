<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modal extends Model
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
    public function bahan()
    {
        return $this->belongsToMany(Bahan::class);
    }
}
