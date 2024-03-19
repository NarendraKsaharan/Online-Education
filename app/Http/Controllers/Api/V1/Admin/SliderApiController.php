<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Http\Resources\Admin\SliderResource;
use App\Models\Slider;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SliderApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('slider_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SliderResource(Slider::all());
    }

    public function store(StoreSliderRequest $request)
    {
        $slider = Slider::create($request->all());

        foreach ($request->input('slider_image', []) as $file) {
            $slider->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('slider_image');
        }

        return (new SliderResource($slider))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Slider $slider)
    {
        abort_if(Gate::denies('slider_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SliderResource($slider);
    }

    public function update(UpdateSliderRequest $request, Slider $slider)
    {
        $slider->update($request->all());

        if (count($slider->slider_image) > 0) {
            foreach ($slider->slider_image as $media) {
                if (! in_array($media->file_name, $request->input('slider_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $slider->slider_image->pluck('file_name')->toArray();
        foreach ($request->input('slider_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $slider->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('slider_image');
            }
        }

        return (new SliderResource($slider))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Slider $slider)
    {
        abort_if(Gate::denies('slider_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slider->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
