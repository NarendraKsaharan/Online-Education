<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStateRequest;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    public function getState(Request $request){
        $countryId = $request->input('country_id');
        $state = State::where('country_id', $countryId)->get();
        $html = '<option value="">Select State</option>';

        foreach ($state as $_state) {
            $html.= '<option value="'.$_state->id.'">'.$_state->name.'</option>';
        }
        return $html;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('state_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = State::with(['country'])->select(sprintf('%s.*', (new State)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'state_show';
                $editGate      = 'state_edit';
                $deleteGate    = 'state_delete';
                $crudRoutePart = 'states';

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
            $table->addColumn('country_name', function ($row) {
                return $row->country ? $row->country->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? State::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'country']);

            return $table->make(true);
        }

        $countries = Country::get();

        return view('admin.states.index', compact('countries'));
    }

    public function create()
    {
        abort_if(Gate::denies('state_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.states.create', compact('countries'));
    }

    public function store(StoreStateRequest $request)
    {
        $state      = State::create($request->all());
        $stateId    = $state->id;
        $cityName   = $request->input('city_name', []);
        $cityStatus = $request->input('city_status', []);
        $countryId  = $state->country_id;
        
        foreach ($cityName as $key => $city_Name) {
            $city_Status = $cityStatus[$key];

            City::create([
                'country_id' => $countryId,
                'state_id'   => $stateId,
                'name'       => $city_Name,
                'status'     => $city_Status
            ]);    
        }
        return redirect()->route('admin.states.index');
    }

    public function edit(State $state)
    {
        abort_if(Gate::denies('state_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $state->load('country');
        $city = City::where('state_id', $state->id)->get();

        return view('admin.states.edit', compact('countries', 'state', 'city'));
    }

    public function update(UpdateStateRequest $request, State $state)
    {
        $state->update($request->all());
        $stateId    = $state->id;
        $countryId  = $state->country_id;
        $cityId     = $request->input('city_id',[]);
        $cityName   = $request->input('city_name',[]);
        $cityStatus = $request->input('city_status',[]);
        
        City::whereNotIn('id', $cityId)->where('state_id', $stateId)->delete();

        foreach ($cityName as $key => $city_name) {
            $city_id = $cityId[$key]??0;
            $city_status = $cityStatus[$key];

            if ($city_id) {
                City::where('id', $city_id)->update([
                    'country_id' => $countryId,
                    'name'       => $city_name,
                    'status'     => $city_status
                ]);
            } else {
                City::create([
                    'country_id' => $countryId,
                    'state_id'   => $stateId,
                    'name'       => $city_name,
                    'status'     => $city_status
                ]);
            }
        }

        return redirect()->route('admin.states.index');
    }

    public function show(State $state)
    {
        abort_if(Gate::denies('state_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state->load('country', 'stateCities', 'stateStudentAddresses');

        return view('admin.states.show', compact('state'));
    }

    public function destroy(State $state)
    {
        abort_if(Gate::denies('state_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state->delete();
        City::where('state_id', $state->id)->delete();

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
