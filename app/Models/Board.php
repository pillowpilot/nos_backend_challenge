<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Board model.
 * 
 * Constructable with only title. Id and Attributes are managed.
 * 
 * In the future, increase serialization control with Eloquent's Resources (https://laravel.com/docs/11.x/eloquent-resources).
 */
class Board extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['title'];
    protected $attributes = [
        'stage' => 1,
    ];
}
