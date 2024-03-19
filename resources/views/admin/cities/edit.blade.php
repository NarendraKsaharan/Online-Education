@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.city.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cities.update", [$city->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="country_id">{{ trans('cruds.city.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id" required>
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $city->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <span class="text-danger">{{ $errors->first('country') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.country_helper') }}</span>
            </div>

            <div class="form-group">
                <label class="required" for="state_id">{{ trans('cruds.city.fields.state') }}</label>
                <select class="form-control" name="state_id" id="state_id" required>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}" {{ ($state->id == $city->state_id)?'selected':'' }} >{{ $state->name }}</option>
                    @endforeach    
                </select>
                @if($errors->has('state'))
                    <span class="text-danger">{{ $errors->first('state') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.state_helper') }}</span>
            </div>
            
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.city.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $city->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.city.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\City::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $city->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.city.fields.status_helper') }}</span>
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
        $('#country_id').select2();

        $('#country_id').on('select2:select', function(){
            countryId = $(this).val();

            $.ajax({
                url: "{{route('admin.get-state')}}",
                method: 'GET',
                data: {'country_id': countryId},
                success: function(res) {
                    // console.log("sbdchjbsdhjcbsdk");
                    $('#state_id').html(res);
                },
                error: function(re) {
                    alert("Something went wrong with your JS code...");
                }
            });
        });
    });
</script>

@endsection