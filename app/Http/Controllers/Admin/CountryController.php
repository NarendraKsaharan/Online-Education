<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCountryRequest;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('country_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Country::query()->select(sprintf('%s.*', (new Country)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'country_show';
                $editGate      = 'country_edit';
                $deleteGate    = 'country_delete';
                $crudRoutePart = 'countries';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Country::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.countries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('country_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.countries.create');
    }

    public function store(StoreCountryRequest $request)
    {
        $country = Country::create($request->all());
        $states = $request->input('state_name', []);
        $stateStatus = $request->input('state_status', []);
        $countryId = $country->id;

        foreach ($states as $key => $state) {
            $state_status = $stateStatus[$key];

            State::create([
                'country_id' => $countryId,
                'name'       => $state,
                'status'     => $state_status
            ]);
        }

        return redirect()->route('admin.countries.index');
    }

    public function edit(Country $country)
    {
        abort_if(Gate::denies('country_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countryId = $country->id;
        $states    = State::where('country_id', $countryId)->get();
        return view('admin.countries.edit', compact('country', 'states'));
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $country->update($request->all());
        $countryId   = $country->id;
        $stateId     = $request->input('state_id', []);
        $stateName   = $request->input('state_name', []);
        $stateStatus = $request->input('state_status', []);

        State::whereNotIn('id', $stateId)->where('country_id', $countryId)->delete();
        City::whereNotIn('state_id', $stateId)->where('country_id', $countryId)->delete();

        foreach ($stateName as $key => $state_name) {
            $state_id     = $stateId[$key]??0;
            $state_status = $stateStatus[$key];

            if ($state_id) {
                State::where('id', $state_id)->update([
                    'name'   => $state_name,
                    'status' => $state_status
                ]);
            } else {
                State::create([
                    'country_id' => $countryId,
                    'name'       => $state_name,
                    'status'     => $state_status
                ]);
            }
        }

        return redirect()->route('admin.countries.index');
    }

    public function show(Country $country)
    {
        abort_if(Gate::denies('country_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $country->load('countryStates', 'countryCities', 'countryStudentAddresses');

        return view('admin.countries.show', compact('country'));
    }

    public function destroy(Country $country)
    {
        abort_if(Gate::denies('country_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $country->delete();
        $countryId = $country->id;
        State::where('country_id', $countryId)->delete();
        City::where('country_id', $countryId)->delete();

        return back();
    }

    public function massDestroy(MassDestroyCountryRequest $request)
    {
        $countries = Country::find(request('ids'));

        foreach ($countries as $country) {
            $country->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
