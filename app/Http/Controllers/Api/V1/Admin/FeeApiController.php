<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeeRequest;
use App\Http\Requests\UpdateFeeRequest;
use App\Http\Resources\Admin\FeeResource;
use App\Models\Fee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeeResource(Fee::with(['course', 'student'])->get());
    }

    public function store(StoreFeeRequest $request)
    {
        $fee = Fee::create($request->all());

        return (new FeeResource($fee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fee $fee)
    {
        abort_if(Gate::denies('fee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FeeResource($fee->load(['course', 'student']));
    }

    public function update(UpdateFeeRequest $request, Fee $fee)
    {
        $fee->update($request->all());

        return (new FeeResource($fee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fee $fee)
    {
        abort_if(Gate::denies('fee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
