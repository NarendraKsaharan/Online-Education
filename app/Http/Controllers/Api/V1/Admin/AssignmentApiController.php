<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateAssignmentRequest;
use App\Http\Resources\Admin\AssignmentResource;
use App\Models\Assignment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssignmentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('assignment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AssignmentResource(Assignment::with(['course', 'students'])->get());
    }

    public function store(StoreAssignmentRequest $request)
    {
        $assignment = Assignment::create($request->all());
        $assignment->students()->sync($request->input('students', []));
        foreach ($request->input('image', []) as $file) {
            $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
        }

        foreach ($request->input('pdf', []) as $file) {
            $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pdf');
        }

        return (new AssignmentResource($assignment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AssignmentResource($assignment->load(['course', 'students']));
    }

    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update($request->all());
        $assignment->students()->sync($request->input('students', []));
        if (count($assignment->image) > 0) {
            foreach ($assignment->image as $media) {
                if (! in_array($media->file_name, $request->input('image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $assignment->image->pluck('file_name')->toArray();
        foreach ($request->input('image', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('image');
            }
        }

        if (count($assignment->pdf) > 0) {
            foreach ($assignment->pdf as $media) {
                if (! in_array($media->file_name, $request->input('pdf', []))) {
                    $media->delete();
                }
            }
        }
        $media = $assignment->pdf->pluck('file_name')->toArray();
        foreach ($request->input('pdf', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $assignment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pdf');
            }
        }

        return (new AssignmentResource($assignment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Assignment $assignment)
    {
        abort_if(Gate::denies('assignment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assignment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
