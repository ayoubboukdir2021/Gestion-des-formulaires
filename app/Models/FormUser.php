<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormUser extends Model
{
    use HasFactory;

    protected $table = "form_user";

    protected $guarded = [];

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function users(){
        return $this->belongsTo(User::class,"user_id","id");
    }

}
