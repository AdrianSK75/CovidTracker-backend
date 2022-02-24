<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Radius extends Model
{
    use HasFactory;

    protected $table = 'radii';

    protected $fillable = [
        'game_id',
        'latitude',
        'longitude'
    ];

    public $timestamps = false;

    public function game() {
        return $this->belongsTo(Game::class, 'game_id');
    }
}
