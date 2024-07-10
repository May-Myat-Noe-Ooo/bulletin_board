<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class PasswordReset extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'token'];
//    protected $table = 'password_resets';
//
//    public $timestamps = false;
 /**
     * Create a password reset token for a given email.
     *
     * @param string $email
     * @return string
     */
    public static function createPasswordResetToken(string $email): string
    {
        $token = Str::random(60);

        self::insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);

        return $token;
    }


    /**
     * Find a password reset entry by token.
     *
     * @param string $token
     * @return PasswordReset|null
     */
    public static function findByToken(string $token): ?self
    {
        return self::where('token', $token)->first();
    }

    /**
     * Delete the password reset entry by email.
     *
     * @param string $email
     * @return void
     */
    public static function deleteByEmail(string $email): void
    {
        self::where('email', $email)->delete();
    }
}
