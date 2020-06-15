<?php

namespace App\Http\Resources;

use App\Entity\Page;
use Illuminate\Http\Resources\Json\JsonResource;

class PageListItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
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
            'attachmentCount' => count($page->attachments),
        ];
    }
}
