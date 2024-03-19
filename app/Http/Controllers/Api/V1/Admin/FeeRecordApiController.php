<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\FeeRecordResource;
use App\Models\FeeRecord;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeeRecordApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fee_record_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeeRecordResource(FeeRecord::with(['courses', 'students'])->get());
    }

    public function show(FeeRecord $feeRecord)
    {
        abort_if(Gate::denies('fee_record_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeeRecordResource($feeRecord->load(['courses', 'students']));
    }
}
