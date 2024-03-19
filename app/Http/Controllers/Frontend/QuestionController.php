<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQuestionRequest;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Course;
use App\Models\Student;
use App\Models\Exam;
use App\Models\Question;
use App\Models\UserQuestion;
use App\Models\UserOption;
use App\Models\Option;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('question_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $questions = Question::with(['course', 'exam', 'media'])->get();

        $courses = Course::get();

        $exams = Exam::get();

        return view('frontend.questions.index', compact('courses', 'exams', 'questions'));
    }

    public function create()
    {
        abort_if(Gate::denies('question_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exams = Exam::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.questions.create', compact('courses', 'exams'));
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

        return redirect()->route('frontend.questions.index');
    }

    public function edit(Question $question)
    {
        abort_if(Gate::denies('question_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exams = Exam::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $question->load('course', 'exam');

        return view('frontend.questions.edit', compact('courses', 'exams', 'question'));
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

        return redirect()->route('frontend.questions.index');
    }

    public function show(Question $question)
    {
        abort_if(Gate::denies('question_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->load('course', 'exam', 'questionOptions');

        return view('frontend.questions.show', compact('question'));
    }

    public function destroy(Question $question)
    {
        abort_if(Gate::denies('question_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $question->delete();

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

    public function questionSave(Request $request){
        $data = $request->all();
        // dd($data);
        $user = Auth::user();
        $examId = $data['exam_id'];
        $exam = Exam::where('id', $examId)->first();
        $course = $exam->course;
        // dd($course);
        $questionId = $data['question_id'];
        // dd($questionId);
        $answer = $data['answer'];
        $userAnswer = implode(', ', $answer);
        // dd($answer);

        $question = Question::where('id', $questionId)->first();
        $options = $question->questionOptions;
        

        $userQuestion = UserQuestion::create([
            'user_id' => $user->id,
            'exam_id' => $examId,
            'course_id' => $course->id,
            'question' => $question->question,
            'answer' => $userAnswer
        ]);
        foreach ($options as $option) {
            UserOption::create([
                'user_id' => $user->id,
                'question_id' => $userQuestion->id,
                'option_sequence' => $option->option_sequence,
                'option_value' => $option->option_value,
            ]);
        }
        // return redirect()->back();

       
    }
}
