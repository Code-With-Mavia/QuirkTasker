<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'action',
        'data',
    ];

    public function ActivityLogger()
    {
        return $this->belongsTo(ActivityLogger::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Tasks()
    {
        return $this->belongsTo(Tasks::class);
    }
}
