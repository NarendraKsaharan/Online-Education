@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.page.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.pages.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="parent_page_id">{{ trans('cruds.page.fields.parent_page') }}</label>
                            <select class="form-control select2" name="parent_page_id" id="parent_page_id">
                                @foreach($parent_pages as $id => $entry)
                                    <option value="{{ $id }}" {{ old('parent_page_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('parent_page'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('parent_page') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.parent_page_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.page.fields.title') }}</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                            @if($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="heading">{{ trans('cruds.page.fields.heading') }}</label>
                            <input class="form-control" type="text" name="heading" id="heading" value="{{ old('heading', '') }}" required>
                            @if($errors->has('heading'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('heading') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.heading_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.page.fields.show_in_menu') }}</label>
                            <select class="form-control" name="show_in_menu" id="show_in_menu" required>
                                <option value disabled {{ old('show_in_menu', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Page::SHOW_IN_MENU_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('show_in_menu', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('show_in_menu'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('show_in_menu') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.show_in_menu_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.page.fields.show_in_footer') }}</label>
                            <select class="form-control" name="show_in_footer" id="show_in_footer" required>
                                <option value disabled {{ old('show_in_footer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Page::SHOW_IN_FOOTER_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('show_in_footer', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('show_in_footer'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('show_in_footer') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.show_in_footer_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.page.fields.status') }}</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Page::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.page.fields.description') }}</label>
                            <textarea class="form-control ckeditor" name="description" id="description">{!! old('description') !!}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="page_image">{{ trans('cruds.page.fields.page_image') }}</label>
                            <div class="needsclick dropzone" id="page_image-dropzone">
                            </div>
                            @if($errors->has('page_image'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('page_image') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.page_image_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="slug">{{ trans('cruds.page.fields.slug') }}</label>
                            <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug', '') }}" required>
                            @if($errors->has('slug'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('slug') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.slug_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="meta_tag">{{ trans('cruds.page.fields.meta_tag') }}</label>
                            <input class="form-control" type="text" name="meta_tag" id="meta_tag" value="{{ old('meta_tag', '') }}" required>
                            @if($errors->has('meta_tag'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('meta_tag') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.meta_tag_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="meta_title">{{ trans('cruds.page.fields.meta_title') }}</label>
                            <input class="form-control" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', '') }}" required>
                            @if($errors->has('meta_title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('meta_title') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.meta_title_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="meta_description">{{ trans('cruds.page.fields.meta_description') }}</label>
                            <textarea class="form-control" name="meta_description" id="meta_description" required>{{ old('meta_description') }}</textarea>
                            @if($errors->has('meta_description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('meta_description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.page.fields.meta_description_helper') }}</span>
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
                xhr.open('POST', '{{ route('frontend.pages.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $page->id ?? 0 }}');
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
    var uploadedPageImageMap = {}
Dropzone.options.pageImageDropzone = {
    url: '{{ route('frontend.pages.storeMedia') }}',
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
      $('form').append('<input type="hidden" name="page_image[]" value="' + response.name + '">')
      uploadedPageImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPageImageMap[file.name]
      }
      $('form').find('input[name="page_image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($page) && $page->page_image)
      var files = {!! json_encode($page->page_image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="page_image[]" value="' + file.file_name + '">')
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