<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Get the user data for the category/(inverse)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task data for the category.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
