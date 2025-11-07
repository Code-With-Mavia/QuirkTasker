<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'priority',
        'due',
    ];

    public function Tasks()
    {
        return $this->belongsTo(Tasks::class);
    }

    public function ActivityLogger()
    {
        return $this->belongsTo(ActivityLogger::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

}
