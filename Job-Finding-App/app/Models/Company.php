<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable=['name','website','description','email','phone','user_id'];


    public function jobs(){
        return $this->hasMany(Job::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}


