<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'name',
        'difficulty',
        'longitude',
        'latitude',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function radii() {
        return $this->hasMany(Radius::class);
    }
    public function group() {
        return $this->hasMany(Group::class);
    }

}
