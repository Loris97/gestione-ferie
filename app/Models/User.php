<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User
 * Rappresenta un utente del sistema (admin o dipendente).
 */
class User extends Authenticatable
{
    /** Abilita factory e notifiche per il model */
    use HasFactory, Notifiable;

    /**
     * Attributi assegnabili in massa (mass assignment).
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'ruolo', 'must_change_password', 'fk_dipendente'];

    /**
     * Attributi nascosti quando il model viene serializzato (es. in JSON).
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attributi da castare a tipi specifici.
     * - email_verified_at: cast a datetime
     * - password: cast a hashed (Laravel 10+)
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relazione con il model Dipendente.
     * Un utente può essere collegato a un dipendente tramite fk_dipendente.
     */
    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class, 'fk_dipendente');
    }
}
