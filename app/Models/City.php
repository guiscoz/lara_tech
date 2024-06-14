<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'state_id' => 'integer',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function campuses()
    {
        return $this->hasMany(Campus::class);
    }
}
