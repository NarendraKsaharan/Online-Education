@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.state.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.states.update", [$state->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="country_id">{{ trans('cruds.state.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" required>
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $state->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.state.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $state->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.state.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\State::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $state->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.status_helper') }}</span>
            </div>
            <div class="add-more-table" style="width:100%">
                <label for="">Add City</label>
                <table width="100%" style="border: 1px solid lightgrey;" id="state-table">
                    <tr>
                        <th><label for="city_name" class="required">Name</label></th>
                        <th><label for="city_status" class="required">Status</label></th>
                        <th><input class="form-control add-row button" type="button" value="Add"></th>
                    </tr>
                    @foreach($city as $_city)
                        <tr>
                            <td>
                                <input type="hidden" name="city_id[]" value="{{ $_city->id }}">
                                <input class="form-control" type="text" name="city_name[]" id="state_name" value="{{ old('city_name', $_city->name) }}" required>
                            </td>
                            <td>
                                <select class="form-control" name="city_status[]" id="city_status">
                                    <option value="">Select Status</option>
                                    <option value="1" {{($_city->status == 1)? 'selected':''}}>Enable</option>
                                    <option value="2" {{($_city->status == 2)? 'selected':''}}>Disable</option>
                                </select>
                            </td>
                            <td><input class="form-control remove" type="button" value="X" ></td>
                        </tr>
                    @endforeach                                         
                </table>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection


@section('scripts')
<script>
    $(document).ready(function(){
        $('#state-table .add-row').click(function(){
            row = '<tr><td><input class="form-control" type="text" name="city_name[]" id="city_name" value="{{ old("city_name") }}" required></td><td><select class="form-control" name="city_status[]" id="city_status">option value="">Select Status</option><option value="1">Enable</option><option value="2">Disable</option></select></td><td><input class="form-control remove" type="button" value="X"></td></tr>';
            $('#state-table').append(row);
        });
        $('#state-table').delegate('.remove', 'click', function(){
        $(this).closest('tr').remove();
    });
    });
</script>
@endsection