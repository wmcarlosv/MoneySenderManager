<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $table = 'shipments';

    public function sender(){
        return $this->belongsTo('App\Models\Person','sender_person_id','id');
    }

    public function receiver(){
        return $this->belongsTo('App\Models\Person','receiver_person_id','id');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public function service(){
        return $this->belongsTo('App\Models\Service');
    }
}
