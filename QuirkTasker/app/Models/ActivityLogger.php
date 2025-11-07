<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger extends Model
{
    use HasFactory;

    protected $table = 'activity_logger';

    protected $fillable = [
        'user_id',
        'task_id',
        'action',
        'data',
    ];

    public $timestamps = false; 
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    // An Activity Log belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An Activity Log belongs to a Task
    public function task()
    {
        return $this->belongsTo(Tasks::class);
    }
}
