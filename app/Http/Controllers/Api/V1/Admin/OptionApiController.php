<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Http\Resources\Admin\OptionResource;
use App\Models\Option;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('option_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OptionResource(Option::with(['question'])->get());
    }

    public function store(StoreOptionRequest $request)
    {
        $option = Option::create($request->all());

        foreach ($request->input('option_image', []) as $file) {
            $option->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('option_image');
        }

        return (new OptionResource($option))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Option $option)
    {
        abort_if(Gate::denies('option_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OptionResource($option->load(['question']));
    }

    public function update(UpdateOptionRequest $request, Option $option)
    {
        $option->update($request->all());

        if (count($option->option_image) > 0) {
            foreach ($option->option_image as $media) {
                if (! in_array($media->file_name, $request->input('option_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $option->option_image->pluck('file_name')->toArray();
        foreach ($request->input('option_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $option->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('option_image');
            }
        }

        return (new OptionResource($option))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Option $option)
    {
        abort_if(Gate::denies('option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $option->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
