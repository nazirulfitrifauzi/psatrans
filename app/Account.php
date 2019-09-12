<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
  protected $table = 'shipper_acc';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'update_time',
  ];
}
