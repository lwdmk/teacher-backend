<?php

namespace App\Http\Resources;

use App\Entity\Test\Test;
use Illuminate\Http\Resources\Json\JsonResource;

class TestListItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Test $test */
        $test = $this;
        return [
            'id' => $test->id,
            'title' => $test->title,
            'type' => $test->type,
            'grade' => $test->grade,
            'short' => $test->short,
            'description' => $test->description,
            'duration' => $test->duration,
            'questionsCount' => count($test->questions)
        ];
    }
}
