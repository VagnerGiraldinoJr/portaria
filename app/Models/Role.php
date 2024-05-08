<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // id, name, slug, description, created_at, updated_at
    protected $fillable = [
        'name', 'slug', 'description',
    ];
}
