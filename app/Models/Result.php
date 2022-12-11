<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
      'nominee_id',
      'position_id',
      'nominee',
      'position',
      'vote_count',
    ];

    public $timestamps = false;
}
