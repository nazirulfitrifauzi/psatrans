<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallRemark extends Model
{
  protected $table = 'call_remarks';

  protected $guarded = [];

  public $timestamps = false;

  protected $dates = [
    'datetime',
  ];

  public function call()
  {
    return $this->belongsTo(Call::class);
  }
}
