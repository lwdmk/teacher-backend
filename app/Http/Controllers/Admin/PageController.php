<?php

namespace App\Http\Controllers\Admin;

use App\Entity\File;
use App\Entity\Page;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pages\AttachmentsRequest;
use App\Http\Requests\Admin\Pages\PageRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin-panel');
    }

    public function index()
    {
        $pages = Page::defaultOrder()->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request)
    {
        $page = Page::create(
            [
                'title' => $request['title'],
                'slug' => $request['slug'],
                'menu_title' => $request['menu_title'],
                'content' => $request['content'],
                'description' => $request['description'],
            ]
        );

        return redirect()->route('admin.pages.show', $page);
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function attachmentsForm(Page $page)
    {
        return view('admin.pages.attachments', compact('page'));
    }

    public function attachments(AttachmentsRequest $request, Page $page)
    {
        try {
            DB::transaction(
                function () use ($request, $page) {
                    /** @var UploadedFile $file */
                    foreach ($request['files'] as $file) {
                        $page->attachments()->create(
                            [
                                'filename' => $file->getClientOriginalName(),
                                'file' => $file->store('page', 'public'),
                                'is_image' => strpos($file->getMimeType(), 'image') !== false,
                            ]
                        );
                    }
                    $page->update();
                }
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.pages.show', $page);
    }

    public function deleteAttachment(Page $page, File $file)
    {
        $file->delete();
        return redirect()->route('admin.pages.show', $page);
    }

    public function update(PageRequest $request, Page $page)
    {
        $page->update(
            [
                'title' => $request['title'],
                'slug' => $request['slug'],
                'menu_title' => $request['menu_title'],
                'content' => $request['content'],
                'description' => $request['description'],
            ]
        );

        return redirect()->route('admin.pages.show', $page);
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index');
    }
}
