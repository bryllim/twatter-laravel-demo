<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twat extends Model
{
    use HasFactory;

    protected $table = 'twats';

    protected $fillable = [
        'content',
        'user_id',
    ];

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }

    public function countReaction(string $type) {
        return Reaction::where(['reaction' => $type, 'twat_id' => $this->id])->count();
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
