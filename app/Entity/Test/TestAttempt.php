<?php

namespace App\Entity\Test;

use App\Entity\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property integer $test_id
 * @property string $name
 * @property string $hash
 * @property string $data
 * @property integer $score
 * @property integer $duration
 * @property string $created_at
 * @property string $updated_at
 * @property string $completed_at
 * @property string $ended_at
 *
 * @property Test $test
 *
 * @method Builder uncompletedByHash(string $hash)
 * @method Builder byTest(Test $test)
 * @method Builder orderedByCreatedDesc()
 */

class TestAttempt extends Model
{
    protected $table = 'test_attempt';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function test()
    {
        return $this->hasOne(Test::class, 'id', 'test_id');
    }

    /**
     * @param Builder $query
     * @param string $hash
     * @return Builder
     */
    public function scopeUncompletedByHash(Builder $query, string $hash)
    {
        return $query->where('ended_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->whereNull('completed_at')
            ->where('hash', $hash);
    }

    /**
     * @param Builder $query
     * @param Test $test
     * @return Builder
     */
    public function scopeByTest(Builder $query, Test $test)
    {
        return $query->where('test_id', $test->id)->orderByDesc('created_at');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrderedByCreatedDesc(Builder $query)
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return is_null($this->completed_at) && Carbon::createFromTimeString($this->ended_at) < Carbon::now();
    }

    /**
     * @return bool
     */
    public function isNotCompleted()
    {
        return is_null($this->completed_at) && Carbon::createFromTimeString($this->ended_at) > Carbon::now();
    }
}
