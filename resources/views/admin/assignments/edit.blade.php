@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.assignment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.assignments.update", [$assignment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label class="required" for="course_id">{{ trans('cruds.assignment.fields.course') }}</label>
                    <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                        @foreach($courses as $id => $entry)
                            <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $assignment->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('course'))
                        <span class="text-danger">{{ $errors->first('course') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.assignment.fields.course_helper') }}</span>
                </div>
              </div>
            
              <div class="col-md-6">
                <div class="form-group">
                    <label class="required" for="students">{{ trans('cruds.assignment.fields.student') }}</label>
                    <select class="form-control select2 {{ $errors->has('students') ? 'is-invalid' : '' }}" name="students[]" id="students" multiple required>
                      @foreach($students as $id => $student)
                      <option value="{{ $id }}" {{ (in_array($id, old('students', [])) || $assignment->students->contains($id)) ? 'selected' : '' }}>{{ $student }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('students'))
                    <span class="text-danger">{{ $errors->first('students') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.assignment.fields.student_helper') }}</span>
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
                    <label class="required" for="title">{{ trans('cruds.assignment.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $assignment->title) }}" required>
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.assignment.fields.title_helper') }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="required" for="points">{{ trans('cruds.assignment.fields.points') }}</label>
                  <input class="form-control {{ $errors->has('points') ? 'is-invalid' : '' }}" type="number" name="points" id="points" value="{{ old('points', $assignment->points) }}" step="1" required>
                  @if($errors->has('points'))
                  <span class="text-danger">{{ $errors->first('points') }}</span>
                  @endif
                  <span class="help-block">{{ trans('cruds.assignment.fields.points_helper') }}</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="image">{{ trans('cruds.assignment.fields.image') }}</label>
                  <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                  </div>
                  @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                  @endif
                    <span class="help-block">{{ trans('cruds.assignment.fields.image_helper') }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="pdf">{{ trans('cruds.assignment.fields.pdf') }}</label>
                  <div class="needsclick dropzone {{ $errors->has('pdf') ? 'is-invalid' : '' }}" id="pdf-dropzone">
                    </div>
                    @if($errors->has('pdf'))
                    <span class="text-danger">{{ $errors->first('pdf') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.assignment.fields.pdf_helper') }}</span>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="description">{{ trans('cruds.assignment.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $assignment->description) !!}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.assignment.fields.description_helper') }}</span>
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
    $(document).ready(function(){
        $('#course_id').select2();

        $('#course_id').on('select2:select', function(){
            courseId = $(this).val();
            // alert(courseId);

            $.ajax({
                url: "{{route('admin.get-student')}}",
                method: 'GET',
                data: {'course_id': courseId},
                success: function(res) {
                    // console.log("sbdchjbsdhjcbsdk");
                    $('#students').html(res);
                },
                error: function(re) {
                    alert("Something went wrong with your JS code...");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.assignments.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $assignment->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedImageMap = {}
Dropzone.options.imageDropzone = {
    url: '{{ route('admin.assignments.storeMedia') }}',
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
      $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
      uploadedImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImageMap[file.name]
      }
      $('form').find('input[name="image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($assignment) && $assignment->image)
      var files = {!! json_encode($assignment->image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="image[]" value="' + file.file_name + '">')
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
<script>
    var uploadedPdfMap = {}
Dropzone.options.pdfDropzone = {
    url: '{{ route('admin.assignments.storeMedia') }}',
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="pdf[]" value="' + response.name + '">')
      uploadedPdfMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPdfMap[file.name]
      }
      $('form').find('input[name="pdf[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($assignment) && $assignment->pdf)
          var files =
            {!! json_encode($assignment->pdf) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="pdf[]" value="' + file.file_name + '">')
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