<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * The users that belong to the company.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the tickets for this company.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
