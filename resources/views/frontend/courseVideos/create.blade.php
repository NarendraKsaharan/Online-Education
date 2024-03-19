@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.courseVideo.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.course-videos.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="course_id">{{ trans('cruds.courseVideo.fields.course') }}</label>
                            <select class="form-control select2" name="course_id" id="course_id" required>
                                @foreach($courses as $id => $entry)
                                    <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('course'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('course') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.courseVideo.fields.course_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="topic_id">{{ trans('cruds.courseVideo.fields.topic') }}</label>
                            <select class="form-control select2" name="topic_id" id="topic_id" required>
                                @foreach($topics as $id => $entry)
                                    <option value="{{ $id }}" {{ old('topic_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('topic'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('topic') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.courseVideo.fields.topic_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="video_title">{{ trans('cruds.courseVideo.fields.video_title') }}</label>
                            <input class="form-control" type="text" name="video_title" id="video_title" value="{{ old('video_title', '') }}" required>
                            @if($errors->has('video_title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('video_title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.courseVideo.fields.video_title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="video_description">{{ trans('cruds.courseVideo.fields.video_description') }}</label>
                            <textarea class="form-control ckeditor" name="video_description" id="video_description">{!! old('video_description') !!}</textarea>
                            @if($errors->has('video_description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('video_description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.courseVideo.fields.video_description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="video_source">{{ trans('cruds.courseVideo.fields.video_source') }}</label>
                            <textarea class="form-control" name="video_source" id="video_source">{{ old('video_source') }}</textarea>
                            @if($errors->has('video_source'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('video_source') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.courseVideo.fields.video_source_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
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
                xhr.open('POST', '{{ route('frontend.course-videos.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $courseVideo->id ?? 0 }}');
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

@endsection