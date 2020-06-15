<?php

namespace App\Entity\Test;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $short
 * @property integer $type
 * @property integer $grade
 * @property integer $duration
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Collection $questions
 */
class Test extends Model
{
    const TYPE_PER_REGISTER_USER = 1;

    protected $table = 'test';

    protected $fillable = [
        'title', 'type', 'grade', 'duration', 'short', 'description'
    ];

    /**
     * @return array
     */
    public static function getTypesList(): array
    {
        return [
            self::TYPE_PER_REGISTER_USER => 'Для пользователей'
        ];
    }

    /**
     * @return string
     */
    public function getTypeDescription(): string
    {
        return array_key_exists($this->type, self::getTypesList()) ? self::getTypesList()[$this->type] : '';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(TestQuestion::class, 'test_id', 'id');
    }
}
