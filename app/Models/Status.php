<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }
=======
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
>>>>>>> main
}
