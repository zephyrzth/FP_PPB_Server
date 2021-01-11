<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id', 'judul', 'harga', 'filename', 'path'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
