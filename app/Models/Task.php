<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Get the category data for the Task/(inverse)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    use HasFactory;

    /**
     * Get the user data for the Task/(inverse)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
