@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.country.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.countries.update", [$country->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.country.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $country->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.country.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Country::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $country->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.country.fields.status_helper') }}</span>
            </div>
            <div class="add-more-table" style="width:100%">
                <label for="">Add State</label>
                <table width="100%" style="border: 1px solid lightgrey;" id="country-table">
                    <tr>
                        <th><label for="state_name" class="required">Name</label></th>
                        <th><label for="state_status" class="required">Status</label></th>
                        <th><input class="form-control add-row button" type="button" value="Add" ></th>
                    </tr>
                    @foreach($states as $state)
                    <tr>
                        <td>
                            <input type="hidden" name="state_id[]" value="{{ $state->id }}">
                            <input class="form-control" type="text" name="state_name[]" id="state_name" value="{{ old('state_name', $state->name) }}" required>
                        </td>
                        <td>
                            <select class="form-control" name="state_status[]" id="state_status">
                                <option value="">Select Status</option>
                                <option value="1" {{ ($state->status == 1)?'selected':'' }}>Enable</option>
                                <option value="2" {{ ($state->status == 2)?'selected':'' }}>Disable</option>
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
        $('#country-table .add-row').click(function(){
            row = '<tr><td><input class="form-control" type="text" name="state_name[]" id="state_name" value="{{ old("state_name") }}" required></td><td><select class="form-control" name="state_status[]" id="state_status">option value="">Select Status</option><option value="1">Enable</option><option value="2">Disable</option></select></td><td><input class="form-control remove" type="button" value="X"></td></tr>';
            $('#country-table').append(row);
        });
        $('#country-table').delegate('.remove', 'click', function(){
        $(this).closest('tr').remove();
    });
    });
</script>

@endsection