<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $menu_title
 * @property string $slug
 * @property string $content
 * @property string $description
 * @property int|null $parent_id
 *
 * @property File[] $attachments
 *
 */
class Page extends Model
{
    protected $table = 'pages';

    protected $guarded = [];

    public function getMenuTitle(): string
    {
        return $this->menu_title ?: $this->title;
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDefaultOrder(Builder $query)
    {
        return $query->orderByDesc('created_at');
    }

    public function attachments()
    {
        return $this->hasMany(File::class, 'page_id', 'id');
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        foreach ($this->attachments as $file) {
            $file->delete();
        }
        return parent::delete();
    }
}
