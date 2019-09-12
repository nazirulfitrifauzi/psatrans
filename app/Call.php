<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
  protected $table = 'call_log';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'datetime',
  ];

  public function remark()
  {
    return $this->hasMany('App\CallRemark','call_id','id');
  }
}
