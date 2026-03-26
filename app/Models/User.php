<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'USERS';

    protected $primaryKey = 'USERID';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'USERID',
        'EMAIL',
        'PASSWORDHASH',
        'SYSTEMROLE',
        'ISACTIVE',
        'ALIAS',
        'COMPANY',
        'POSTCODE',
        'CITY',
        'LASTLOGIN',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'PASSWORDHASH',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'ISACTIVE' => 'boolean',
            'LASTLOGIN' => 'datetime',
        ];
    }

    public function getAuthPassword(): string
    {
        return (string) ($this->PASSWORDHASH ?? '');
    }
}
