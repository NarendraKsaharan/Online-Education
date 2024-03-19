<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;
use App\Http\Resources\Admin\BlockResource;
use App\Models\Block;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('block_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlockResource(Block::all());
    }

    public function store(StoreBlockRequest $request)
    {
        $block = Block::create($request->all());

        foreach ($request->input('block_image', []) as $file) {
            $block->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('block_image');
        }

        return (new BlockResource($block))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Block $block)
    {
        abort_if(Gate::denies('block_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlockResource($block);
    }

    public function update(UpdateBlockRequest $request, Block $block)
    {
        $block->update($request->all());

        if (count($block->block_image) > 0) {
            foreach ($block->block_image as $media) {
                if (! in_array($media->file_name, $request->input('block_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $block->block_image->pluck('file_name')->toArray();
        foreach ($request->input('block_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $block->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('block_image');
            }
        }

        return (new BlockResource($block))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Block $block)
    {
        abort_if(Gate::denies('block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $block->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
