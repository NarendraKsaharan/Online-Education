@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.option.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.options.update", [$option->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="question_id">{{ trans('cruds.option.fields.question') }}</label>
                        <select class="form-control select2 {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question_id" id="question_id" required>
                            @foreach($questions as $id => $entry)
                                <option value="{{ $id }}" {{ (old('question_id') ? old('question_id') : $option->question->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('question'))
                            <span class="text-danger">{{ $errors->first('question') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.option.fields.question_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.option.fields.option_sequence') }}</label>
                        <select class="form-control {{ $errors->has('option_sequence') ? 'is-invalid' : '' }}" name="option_sequence" id="option_sequence" required>
                            <option value disabled {{ old('option_sequence', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Option::OPTION_SEQUENCE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('option_sequence', $option->option_sequence) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('option_sequence'))
                            <span class="text-danger">{{ $errors->first('option_sequence') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.option.fields.option_sequence_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="option_value">{{ trans('cruds.option.fields.option_value') }}</label>
                        <input class="form-control {{ $errors->has('option_value') ? 'is-invalid' : '' }}" type="text" name="option_value" id="option_value" value="{{ old('option_value', $option->option_value) }}" required>
                        @if($errors->has('option_value'))
                            <span class="text-danger">{{ $errors->first('option_value') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.option.fields.option_value_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="option_image">{{ trans('cruds.option.fields.option_image') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('option_image') ? 'is-invalid' : '' }}" id="option_image-dropzone">
                        </div>
                        @if($errors->has('option_image'))
                            <span class="text-danger">{{ $errors->first('option_image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.option.fields.option_image_helper') }}</span>
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
    var uploadedOptionImageMap = {}
Dropzone.options.optionImageDropzone = {
    url: '{{ route('admin.options.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
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
      $('form').append('<input type="hidden" name="option_image[]" value="' + response.name + '">')
      uploadedOptionImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedOptionImageMap[file.name]
      }
      $('form').find('input[name="option_image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($option) && $option->option_image)
      var files = {!! json_encode($option->option_image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="option_image[]" value="' + file.file_name + '">')
        }
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