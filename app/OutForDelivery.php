<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutForDelivery extends Model
{
  protected $table = 'out_for_delivery';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'datetime',
  ];

  public function scopeSearch($query, $s)
  {
    return $query->where('cn_no','like','%'.$s.'%')
                  ->orWhere('shipper_code','like','%'.$s.'%')
                  ->orWhere('destination_code','like','%'.$s.'%')
                  ->orWhere('driver_name','like','%'.$s.'%')
                  ->orWhere('status','like','%'.$s.'%');
  }
}
