<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function controls() {
        return $this->hasMany(Control::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
