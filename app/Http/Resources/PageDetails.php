<?php

namespace App\Http\Resources;

use App\Entity\File;
use App\Entity\Page;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TestDetails
 * @package App\Http\Resources
 */
class PageDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Page $page */
        $page = $this;
        return [
            'id' => $page->id,
            'title' => $page->title,
            'menu_title' => $page->menu_title,
            'slug' => $page->slug,
            'description' => $page->description,
            'content' => $page->content,
            'attachmentCount' => count($page->attachments),
            'attachments' => $page->attachments->map(
                function (File $file) {
                    return [
                        'id' => $file,
                        'filename' => $file->filename,
                        'file' => $file->file,
                        'is_image' => (int)$file->is_image,
                    ];
                }
            )
        ];
    }
}
