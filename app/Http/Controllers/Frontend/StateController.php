<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStateRequest;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Models\Country;
use App\Models\State;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StateController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('state_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $states = State::with(['country'])->get();

        $countries = Country::get();

        return view('frontend.states.index', compact('countries', 'states'));
    }

    public function create()
    {
        abort_if(Gate::denies('state_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.states.create', compact('countries'));
    }

    public function store(StoreStateRequest $request)
    {
        $state = State::create($request->all());

        return redirect()->route('frontend.states.index');
    }

    public function edit(State $state)
    {
        abort_if(Gate::denies('state_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $state->load('country');

        return view('frontend.states.edit', compact('countries', 'state'));
    }

    public function update(UpdateStateRequest $request, State $state)
    {
        $state->update($request->all());

        return redirect()->route('frontend.states.index');
    }

    public function show(State $state)
    {
        abort_if(Gate::denies('state_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state->load('country', 'stateCities');

        return view('frontend.states.show', compact('state'));
    }

    public function destroy(State $state)
    {
        abort_if(Gate::denies('state_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state->delete();

        return back();
    }

    public function massDestroy(MassDestroyStateRequest $request)
    {
        $states = State::find(request('ids'));

        foreach ($states as $state) {
            $state->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
