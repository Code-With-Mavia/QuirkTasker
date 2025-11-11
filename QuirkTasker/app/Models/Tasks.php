<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'priority',
        'due',
    ];
    public $timestamps = false;

    // A Task belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // // A Log belongs to Tasks
    // public function activity_logger() 
    // {
    //     return $this->belongsTo(ActivityLogger::class );
    // }

    // A Task has many Activity Logs
    public function activityLogs()
    {
        return $this->hasMany(ActivityLogger::class);
    }
    
}
