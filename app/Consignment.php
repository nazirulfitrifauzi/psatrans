<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Consignment extends Model
{
  protected $table = 'consignment';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'cn_datetime',
  ];

  public function scopeSearch($query, $search)
  {
    return $query->where('cn_no','like','%'.$search.'%')
                  ->orWhere('shipper_code','like','%'.$search.'%')
                  ->orWhere('destination_code','like','%'.$search.'%')
                  ->orWhere('driver_name','like','%'.$search.'%')
                  ->orWhere('cn_datetime','like','%'.$search.'%');
  }

}
