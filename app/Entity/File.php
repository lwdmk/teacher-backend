<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string file
 * @property string filename
 * @property bool is_image
 */
class File extends Model
{
    protected $table = 'files';

    public $timestamps = false;

    protected $fillable = ['file', 'filename', 'is_image'];

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        \Storage::delete($this->file);
        return parent::delete();
    }
}
