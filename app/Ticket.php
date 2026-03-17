<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
            'user_id', 'category_id', 'ticket_id', 'title', 'priority_id', 'message', 'status_id',
            'technical_staff_id', 'company_id', 'work_time',
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technicalStaff()
    {
        return $this->belongsTo(TechnicalStaff::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get formatted work time in hours and minutes.
     */
    public function getFormattedWorkTime()
    {
        if (is_null($this->work_time)) {
            return '-';
        }

        $hours = floor($this->work_time / 60);
        $minutes = $this->work_time % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }
}
