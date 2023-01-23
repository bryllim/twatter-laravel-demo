<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $table = "reactions";

    protected $fillable = [
        'reaction',
        'user_id',
        'twat_id',
    ];

    public function twat(){
        return $this->belongsTo(Twat::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
