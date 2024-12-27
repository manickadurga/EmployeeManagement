<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'username', 'email', 'password', 'start_date'];

    protected $hidden = ['password'];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
