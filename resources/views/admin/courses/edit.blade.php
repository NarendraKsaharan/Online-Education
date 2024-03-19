@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.update", [$course->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.course.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required>
                    @if($errors->has('title'))
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.title_helper') }}</span>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="form-group">
                    <label class="required">{{ trans('cruds.course.fields.status') }}</label>
                    <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Course::STATUS_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $course->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.status_helper') }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="fee">{{ trans('cruds.course.fields.fee') }}</label>
                    <input class="form-control {{ $errors->has('fee') ? 'is-invalid' : '' }}" type="number" name="fee" id="fee" value="{{ old('fee', $course->fee) }}" step="0.01">
                    @if($errors->has('fee'))
                        <span class="text-danger">{{ $errors->first('fee') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.fee_helper') }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label class="required">{{ trans('cruds.course.fields.fee_type') }}</label>
                    <select class="form-control {{ $errors->has('fee_type') ? 'is-invalid' : '' }}" name="fee_type" id="fee_type" required>
                        <option value disabled {{ old('fee_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Course::FEE_TYPE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('fee_type', $course->fee_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('fee_type'))
                        <span class="text-danger">{{ $errors->first('fee_type') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.fee_type_helper') }}</span>
                </div>
              </div> 

              <div class="col-md-6">
                <div class="form-group">
                    <label for="image">{{ trans('cruds.course.fields.image') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                    </div>
                    @if($errors->has('image'))
                        <span class="text-danger">{{ $errors->first('image') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.image_helper') }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="pdf">{{ trans('cruds.course.fields.pdf') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('pdf') ? 'is-invalid' : '' }}" id="pdf-dropzone">
                    </div>
                    @if($errors->has('pdf'))
                        <span class="text-danger">{{ $errors->first('pdf') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.pdf_helper') }}</span>
                </div>
              </div>
            </div>
            <!-- row-end -->

                <!-- description -->
                <div class="form-group">
                    <label for="description">{{ trans('cruds.course.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $course->description) !!}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.course.fields.description_helper') }}</span>
                </div>
                <!-- description-end -->

            <!-- topic-data -->
            <div class="form-group">
              <label for="topic">Add Topic</label>
              <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                          <table class="table table-bordered">
                              <tr>
                                  <th>Title</th>
                                  <th>Status</th>
                                  <th><input type="button" value="ADD" class="form-control add-row button"></th>
                              </tr>
                              @foreach($topics as $topic)
                                <tr>
                                  <td>
                                    <input type="hidden" name="topic_id[]" value="{{ $topic->id }}">
                                    <input type="text" name="topic_title[]" value="{{ old('topic_title', $topic->title) }}" id="topic_title" class="form-control"></td>
                                  <td>
                                    <select name="topic_status[]" id="" class="form-control">
                                      <option value="1" {{ ($topic->status == 1)? 'selected':'' }}>Enable</option>
                                      <option value="2" {{ ($topic->status == 2)? 'selected':'' }}>Disable</option>
                                    </select>
                                  </td>
                                  <td><input type="button" value="X" class="form-control remove button"></td>
                                </tr>
                              @endforeach  
                          </table>
                      </div>
                  </div>
              </div>
            </div> 
            <!-- topic-data-end -->   
                
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
    $('.table .add-row').click(function(){
      row = '<tr>\
              <td><input type="text" name="topic_title[]" id="topic_title" class="form-control"></td>\
              <td><select name="topic_status[]" id="" class="form-control"><option value="1">Enable</option><option value="1">Disable</option></select></td>\
              <td><input type="button" value="X" class="form-control remove"></td>\
            </tr>';

      $('.table').append(row);      
    });

    $('.table').delegate('.remove', 'click', function(){
      $(this).closest('tr').remove();
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
                xhr.open('POST', '{{ route('admin.courses.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $course->id ?? 0 }}');
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
    url: '{{ route('admin.courses.storeMedia') }}',
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
@if(isset($course) && $course->image)
      var files = {!! json_encode($course->image) !!}
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
    url: '{{ route('admin.courses.storeMedia') }}',
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
@if(isset($course) && $course->pdf)
          var files =
            {!! json_encode($course->pdf) !!}
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