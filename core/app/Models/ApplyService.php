<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyService extends Model
{
    use HasFactory;

    public function service(){
    	return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function user(){
    	return $this->hasOne(User::class, 'id', 'user_id');
    }


}
