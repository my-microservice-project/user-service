<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property ?string $name
 * @property ?string $last_name
 * @property ?string $email
 * @property ?string $password
 * @method static create(array $data)
 * @method find(int $id)
 * @method where(string $string, string $email)
 */

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
    ];

}
