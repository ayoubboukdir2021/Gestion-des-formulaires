<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
