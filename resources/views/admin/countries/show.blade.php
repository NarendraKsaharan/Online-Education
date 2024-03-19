@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.country.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.countries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.id') }}
                        </th>
                        <td>
                            {{ $country->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.name') }}
                        </th>
                        <td>
                            {{ $country->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.country.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Country::STATUS_SELECT[$country->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.countries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#country_states" role="tab" data-toggle="tab">
                {{ trans('cruds.state.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#country_cities" role="tab" data-toggle="tab">
                {{ trans('cruds.city.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#country_student_addresses" role="tab" data-toggle="tab">
                {{ trans('cruds.studentAddress.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="country_states">
            @includeIf('admin.countries.relationships.countryStates', ['states' => $country->countryStates])
        </div>
        <div class="tab-pane" role="tabpanel" id="country_cities">
            @includeIf('admin.countries.relationships.countryCities', ['cities' => $country->countryCities])
        </div>
        <div class="tab-pane" role="tabpanel" id="country_student_addresses">
            @includeIf('admin.countries.relationships.countryStudentAddresses', ['studentAddresses' => $country->countryStudentAddresses])
        </div>
    </div>
</div>

@endsection