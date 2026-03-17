<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicalStaff extends Model
{
    protected $table = 'technical_staff';

    protected $fillable = [
        'name',
        'email',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the tickets assigned to this technical staff.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
