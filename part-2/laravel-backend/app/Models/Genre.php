<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $primaryKey = 'genre_id';

    protected $fillable = ['name'];

    // Define the relationship to books
    public function books()
    {
        return $this->hasMany(Book::class, 'genre_id');
    }
}