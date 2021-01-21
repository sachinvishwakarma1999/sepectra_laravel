<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    public $table = 'items';

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project','project_type_id','id');
    }

    public function service()
    {
        return $this->belongsTo('App\Service','service_id','id');
    }

    public function color()
    {
        return $this->belongsTo('App\color','color_id','id');
    }
}
