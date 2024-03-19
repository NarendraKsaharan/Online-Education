@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.student.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.students.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="user_id">{{ trans('cruds.student.fields.user') }}</label>
                        <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                            @foreach($users as $id => $entry)
                                <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('user'))
                            <span class="text-danger">{{ $errors->first('user') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.user_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="courses">{{ trans('cruds.student.fields.course') }}</label>
                        <select class="form-control select2 {{ $errors->has('courses') ? 'is-invalid' : '' }}" name="courses[]" id="courses" multiple>
                            @foreach($courses as $id => $course)
                            <option value="{{ $id }}" {{ in_array($id, old('courses', [])) ? 'selected' : '' }}>{{ $course }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('courses'))
                        <span class="text-danger">{{ $errors->first('courses') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.course_helper') }}</span>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.student.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.name_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">{{ trans('cruds.student.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                        @if($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.email_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">{{ trans('cruds.student.fields.phone') }}</label>
                        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                        @if($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.phone_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.student.fields.gender') }}</label>
                        <div class="form-check form-check-inline form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                            @foreach(App\Models\Student::GENDER_RADIO as $key => $label)
                                <input class="form-check-input ml-2" type="radio" id="gender_{{ $key }}" name="gender" value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'checked' : '' }} required>
                                <label class="form-check-label mr-5" for="gender_{{ $key }}">{{ $label }}</label>
                            @endforeach
                        </div>
                        @if($errors->has('gender'))
                            <span class="text-danger">{{ $errors->first('gender') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.gender_helper') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="join_date">{{ trans('cruds.student.fields.join_date') }}</label>
                        <input class="form-control date {{ $errors->has('join_date') ? 'is-invalid' : '' }}" type="text" name="join_date" id="join_date" value="{{ old('join_date') }}" required>
                        @if($errors->has('join_date'))
                        <span class="text-danger">{{ $errors->first('join_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.join_date_helper') }}</span>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="leave_date">{{ trans('cruds.student.fields.leave_date') }}</label>
                        <input class="form-control date {{ $errors->has('leave_date') ? 'is-invalid' : '' }}" type="text" name="leave_date" id="leave_date" value="{{ old('leave_date') }}">
                        @if($errors->has('leave_date'))
                        <span class="text-danger">{{ $errors->first('leave_date') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.leave_date_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="profile_image">{{ trans('cruds.student.fields.profile_image') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('profile_image') ? 'is-invalid' : '' }}" id="profile_image-dropzone">
                        </div>
                        @if($errors->has('profile_image'))
                            <span class="text-danger">{{ $errors->first('profile_image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.student.fields.profile_image_helper') }}</span>
                    </div>
                </div>
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
    Dropzone.options.profileImageDropzone = {
    url: '{{ route('admin.students.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="profile_image"]').remove()
      $('form').append('<input type="hidden" name="profile_image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="profile_image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($student) && $student->profile_image)
      var file = {!! json_encode($student->profile_image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="profile_image" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection