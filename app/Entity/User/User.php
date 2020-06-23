<?php

namespace App\Entity\User;

use App\Entity\Test\TestAttempt;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property bool $phone_verified
 * @property string $password
 * @property string $verify_token
 * @property string $phone_verify_token
 * @property Carbon $phone_verify_token_expire
 * @property boolean $phone_auth
 * @property string $role
 * @property string $status
 * @property string $access_code
 * @property string $api_token
 * @property int $grade
 * @property string $grade_letter
 *
 * @property TestAttempt $activeTest
 *
 * @method Builder byNetwork(string $network, string $identity)
 */
class User extends Authenticatable
{
    use Notifiable;

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_USER = 'user';
    public const ROLE_ADMIN = 'admin';

    public const GRADE_A = 'A';
    public const GRADE_B = 'B';
    public const GRADE_C = 'C';
    public const GRADE_D = 'Г';
    public const GRADE_E = 'Д';
    public const GRADE_F = 'Е';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'access_code',
        'grade',
        'grade_letter',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array
     */
    public static function rolesList(): array
    {
        return [
            self::ROLE_USER => 'Ученик',
            self::ROLE_ADMIN => 'Админ',
        ];
    }

    /**
     * @return array
     */
    public static function gradeList(): array
    {
        return [
           5 => 5,
           6 => 6,
           7 => 7,
           8 => 8,
           9 => 9,
           10 => 10,
        ];
    }

    /**
     * @return array
     */
    public static function gradeLetterList(): array
    {
        return [
           self::GRADE_A => 'A',
           self::GRADE_B => 'Б',
           self::GRADE_C => 'В',
           self::GRADE_D => 'Г',
           self::GRADE_E => 'Д',
           self::GRADE_F => 'Е',
        ];
    }

    public static function new($name, $email, $password): self
    {
        return static::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
                'role' => self::ROLE_USER,
                'status' => self::STATUS_ACTIVE,
            ]
        );
    }

    public static function newStudent($name, $accessCode, $grade, $gradeLetter): self
    {
        return static::create(
            [
                'name' => $name,
                'role' => self::ROLE_USER,
                'status' => self::STATUS_ACTIVE,
                'access_code' => $accessCode,
                'grade' => $grade,
                'grade_letter' => $gradeLetter,
                'api_token' => \Str::random(80)
            ]
        );
    }

    public function setPassword($password): void
    {
        $this->update(['password' => bcrypt($password)]);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activeTest()
    {
        return $this->hasOne(TestAttempt::class, 'user_id', 'id')
            ->where('ended_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->whereNull('completed_at');
    }
}
