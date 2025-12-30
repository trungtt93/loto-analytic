<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $fillable = [
        'date',
        'db',
        'g1',
        'g2',
        'g3',
        'g4',
        'g5',
        'g6',
        'g7',
    ];

    protected $casts = [
        'date' => 'date',
        'db' => 'array',
        'g1' => 'array',
        'g2' => 'array',
        'g3' => 'array',
        'g4' => 'array',
        'g5' => 'array',
        'g6' => 'array',
        'g7' => 'array',
    ];
}
