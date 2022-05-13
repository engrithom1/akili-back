<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;

    protected $table = 'levels';
    protected $primaryKey = 'id';
    protected $fillable = ['level',];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
