<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'major_id',
        'name',
        'phone',
        'user_id'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
