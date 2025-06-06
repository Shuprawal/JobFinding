<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable=['title','description','company_id','category_id','type','user_id','salary','location','status','deadline','feature'];

    public function category(){
        return $this->hasOne(Category::class);
    }
//    public function user(){
//        return $this->belongsTo(User::class);
//    }
    public function applications(){
        return $this->hasMany(Application::class);
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }

}
