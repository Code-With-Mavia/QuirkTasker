<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable = [
    ];

    public function Tasks()
    {
        return $this->belongsTo(Tasks::class);
    }
}
