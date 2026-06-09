<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'major_id',
        'name',
        'phone'
    ];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'id');
    }

}

// ORM = Object Relation Model
// One to One = never use in relation table
// One to Many = One Major Just for One Student (belongsTo)
// Many to Many
