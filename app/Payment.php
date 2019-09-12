<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'payment';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'datetime',
  ];
}
