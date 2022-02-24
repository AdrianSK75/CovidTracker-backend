<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $fillable = ['game_id'];
    public function users() {
        return $this->belongsToMany(User::class)->using(GroupsUsers::class);
    }
    public function game() {
        return $this->belongsTo(Game::class);
    }
}
