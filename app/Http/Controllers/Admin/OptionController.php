<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyOptionRequest;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Models\Option;
use App\Models\Question;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class OptionController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('option_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Option::with(['question'])->select(sprintf('%s.*', (new Option)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'option_show';
                $editGate      = 'option_edit';
                $deleteGate    = 'option_delete';
                $crudRoutePart = 'options';

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
            $table->addColumn('question_question', function ($row) {
                return $row->question ? $row->question->question : '';
            });

            $table->editColumn('option_sequence', function ($row) {
                return $row->option_sequence ? Option::OPTION_SEQUENCE_SELECT[$row->option_sequence] : '';
            });
            $table->editColumn('option_value', function ($row) {
                return $row->option_value ? $row->option_value : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'question']);

            return $table->make(true);
        }

        $questions = Question::get();

        return view('admin.options.index', compact('questions'));
    }

    public function create()
    {
        abort_if(Gate::denies('option_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::pluck('question', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.options.create', compact('questions'));
    }

    public function store(StoreOptionRequest $request)
    {
        $option = Option::create($request->all());

        foreach ($request->input('option_image', []) as $file) {
            $option->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('option_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $option->id]);
        }

        return redirect()->route('admin.options.index');
    }

    public function edit(Option $option)
    {
        abort_if(Gate::denies('option_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::pluck('question', 'id')->prepend(trans('global.pleaseSelect'), '');

        $option->load('question');

        return view('admin.options.edit', compact('option', 'questions'));
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

        return redirect()->route('admin.options.index');
    }

    public function show(Option $option)
    {
        abort_if(Gate::denies('option_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $option->load('question');

        return view('admin.options.show', compact('option'));
    }

    public function destroy(Option $option)
    {
        abort_if(Gate::denies('option_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $option->delete();

        return back();
    }

    public function massDestroy(MassDestroyOptionRequest $request)
    {
        $options = Option::find(request('ids'));

        foreach ($options as $option) {
            $option->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('option_create') && Gate::denies('option_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Option();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
