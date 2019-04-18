<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  protected $fillable = [
    'id', 'name', 'filter', 'code',
  ];

  //para identificar o array da controller
  protected $casts = [
    'filter' => 'array',
  ];
}
