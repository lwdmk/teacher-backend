<?php

namespace App\Http\Controllers\Api;

use App\Entity\Page;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageDetails;
use App\Http\Resources\PageListItem;

/**
 * Class PageController
 * @package App\Http\Controllers\Api
 */
class PageController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $tests = Page::query()->paginate(20);

        return PageListItem::collection($tests);
    }

    /**
     * @param string $slug
     * @return PageDetails
     */
    public function view(string $slug)
    {
        $page = Page::firstWhere(['slug' => $slug]);
        if (is_null($page)) {
            abort(404);
        }
        return new PageDetails($page);
    }
}
