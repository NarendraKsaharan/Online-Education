<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\Admin\PageResource;
use App\Models\Page;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PageApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PageResource(Page::with(['parent_page'])->get());
    }

    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->all());

        foreach ($request->input('page_image', []) as $file) {
            $page->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('page_image');
        }

        return (new PageResource($page))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Page $page)
    {
        abort_if(Gate::denies('page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PageResource($page->load(['parent_page']));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->all());

        if (count($page->page_image) > 0) {
            foreach ($page->page_image as $media) {
                if (! in_array($media->file_name, $request->input('page_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $page->page_image->pluck('file_name')->toArray();
        foreach ($request->input('page_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $page->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('page_image');
            }
        }

        return (new PageResource($page))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Page $page)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
