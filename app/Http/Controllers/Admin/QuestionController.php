<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQuestionRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Question::with(['course', 'exam'])->select(sprintf('%s.*', (new Question)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'question_show';
                $editGate      = 'question_edit';
                $deleteGate    = 'question_delete';
                $crudRoutePart = 'questions';

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
            $table->addColumn('course_title', function ($row) {
                return $row->course ? $row->course->title : '';
            });

            $table->addColumn('exam_title', function ($row) {
                return $row->exam ? $row->exam->title : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? Question::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? Question::TYPE_SELECT[$row->type] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'exam']);

            return $table->make(true);
        }

        $courses = Course::get();
        $exams   = Exam::get();

        return view('admin.questions.index', compact('courses', 'exams'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exams = Exam::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.questions.create', compact('courses', 'exams'));
    }

    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create($request->all());

        foreach ($request->input('image', []) as $file) {
            $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        foreach ($request->input('answer_image', []) as $file) {
            $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('answer_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $question->id]);
        }

        $optionSeq = $request->input('option_sequence', []);
        $optionValue = $request->input('option_value', []);
        $optionImages = $request->file('option_image');

        foreach ($optionSeq as $key => $sequence) {
            $option_value = $optionValue[$key];
            $option_image = isset($optionImages[$key]) ? $optionImages[$key] : null;

            if (!empty($option_value) || !is_null($option_image)) {
                $option = Option::create([
                    'question_id' => $question->id,
                    'option_sequence' => $sequence,
                    'option_value' => $option_value ?? 0
                ]);

                if (!is_null($option_image) && $option_image->isValid()) {
                    $option->addMedia($option_image)->toMediaCollection('option_image');
                }
            }
        }
        return redirect()->route('admin.questions.index');
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exams = Exam::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $question->load('course', 'exam',);

        $options = Option::where('question_id', $question->id)->get();

        return view('admin.questions.edit', compact('courses', 'exams', 'question', 'options'));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update($request->all());

        if (count($question->image) > 0) {
            foreach ($question->image as $media) {
                if (! in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $question->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        if (count($question->answer_image) > 0) {
            foreach ($question->answer_image as $media) {
                if (! in_array($media->file_name, $request->input('answer_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $question->answer_image->pluck('file_name')->toArray();
        foreach ($request->input('answer_image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $question->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('answer_image');
            }
        }

        $images = $request->input('delete_image', []);
        
        foreach ($images as $image) {
            Media::where('id', $image)->where('collection_name', 'option_image')->delete();
        }

        $optionId = $request->input('option_id', []);
        // dd($optionId);
        $optionSeq = $request->input('option_sequence', []);
        $optionValue = $request->input('option_value', []); 
        $optionImages = $request->file('option_image');


        foreach ($optionId as $key => $id) {
            $value = $optionValue[$key];
            $img = $optionImages[$key]??0;

            if (empty($value) && empty($img)) {
                Option::where('id', $id)->delete();
            }
        }

        foreach ($optionSeq as $key => $sequence) {
            $option_id = $optionId[$key] ?? 0;
            $option_value = $optionValue[$key];
            $option_image = isset($optionImages[$key]) ? $optionImages[$key] : null;
        
            if (!empty($option_value) || !is_null($option_image)) {
                if ($option_id) {
                    $option = Option::find($option_id);
                    if (!$option) {
                        // Handle the case where the Option record is not found (optional)
                        // You can add appropriate error handling here if required.
                        continue;
                    }
        
                    $option->update([
                        'option_sequence' => $sequence,
                        'option_value' => $option_value ?? 0
                    ]);
                } else {
                    $option = Option::create([
                        'question_id' => $question->id,
                        'option_sequence' => $sequence,
                        'option_value' => $option_value ?? 0
                    ]);
                }
        
                // Check if there's a request to delete the existing image
                $delete_image = $request->input('delete_image', []);
                if (in_array($option_id, $delete_image)) {
                    // Delete the old image associated with the option
                    $option->clearMediaCollection('option_image');
                }
        
                if (!is_null($option_image) && $option_image->isValid()) {
                    // If there's a new image uploaded, add it to the media collection
                    $option->addMedia($option_image)->toMediaCollection('option_image');
                }
            }
        }
        

        // foreach ($optionSeq as $key => $sequence) {
        //     $option_id = $optionId[$key]??0;
        //     // dd($option_id);
        //     $option_value = $optionValue[$key];
        //     $option_image = isset($optionImages[$key]) ? $optionImages[$key] : null;

        //     if (!empty($option_value) || !is_null($option_image)) {

        //         if ($option_id) {
        //             $option = Option::where('id', $option_id)->update([
        //                 'option_sequence' => $sequence,
        //                 'option_value' => $option_value ?? 0
        //             ]);
        //         } else {
        //             $option = Option::create([
        //                 'question_id' => $question->id,
        //                 'option_sequence' => $sequence,
        //                 'option_value' => $option_value ?? 0
        //             ]);
        //         }

        //         if (!is_null($option_image) && $option_image->isValid()) {
        //             $option->addMedia($option_image)->toMediaCollection('option_image');
        //         }
        //     }
        // }

        return redirect()->route('admin.questions.index');
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->load('course', 'exam', 'questionOptions');

        return view('admin.questions.show', compact('question'));
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();
        $option = Option::where('question_id', $question->id)->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuestionRequest $request)
    {
        $questions = Question::find(request('ids'));

        foreach ($questions as $question) {
            $question->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('question_create') && Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Question();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
