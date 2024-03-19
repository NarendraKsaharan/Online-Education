<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySliderRequest;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Models\Slider;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('slider_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Slider::query()->select(sprintf('%s.*', (new Slider)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'slider_show';
                $editGate      = 'slider_edit';
                $deleteGate    = 'slider_delete';
                $crudRoutePart = 'sliders';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Slider::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.sliders.index');
    }

    public function create()
    {
        abort_if(Gate::denies('slider_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sliders.create');
    }

    public function store(StoreSliderRequest $request)
    {
        $slider = Slider::create($request->all());

        foreach ($request->input('slider_image', []) as $file) {
            $slider->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('slider_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $slider->id]);
        }

        return redirect()->route('admin.sliders.index');
    }

    public function edit(Slider $slider)
    {
        abort_if(Gate::denies('slider_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sliders.edit', compact('slider'));
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

        return redirect()->route('admin.sliders.index');
    }

    public function show(Slider $slider)
    {
        abort_if(Gate::denies('slider_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.sliders.show', compact('slider'));
    }

    public function destroy(Slider $slider)
    {
        abort_if(Gate::denies('slider_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slider->delete();

        return back();
    }

    public function massDestroy(MassDestroySliderRequest $request)
    {
        $sliders = Slider::find(request('ids'));

        foreach ($sliders as $slider) {
            $slider->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('slider_create') && Gate::denies('slider_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Slider();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
