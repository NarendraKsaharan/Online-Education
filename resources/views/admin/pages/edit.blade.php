@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.page.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pages.update", [$page->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parent_page_id">{{ trans('cruds.page.fields.parent_page') }}</label>
                        <select class="form-control select2 {{ $errors->has('parent_page') ? 'is-invalid' : '' }}" name="parent_page_id" id="parent_page_id">
                            @foreach($parent_pages as $id => $entry)
                                <option value="{{ $id }}" {{ (old('parent_page_id') ? old('parent_page_id') : $page->parent_page->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('parent_page'))
                            <span class="text-danger">{{ $errors->first('parent_page') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.parent_page_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.page.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required>
                        @if($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.title_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                        <label class="required" for="heading">{{ trans('cruds.page.fields.heading') }}</label>
                        <input class="form-control {{ $errors->has('heading') ? 'is-invalid' : '' }}" type="text" name="heading" id="heading" value="{{ old('heading', $page->heading) }}" required>
                        @if($errors->has('heading'))
                            <span class="text-danger">{{ $errors->first('heading') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.heading_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.page.fields.show_in_menu') }}</label>
                        <select class="form-control {{ $errors->has('show_in_menu') ? 'is-invalid' : '' }}" name="show_in_menu" id="show_in_menu" required>
                            <option value disabled {{ old('show_in_menu', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Page::SHOW_IN_MENU_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('show_in_menu', $page->show_in_menu) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('show_in_menu'))
                            <span class="text-danger">{{ $errors->first('show_in_menu') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.show_in_menu_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.page.fields.show_in_footer') }}</label>
                        <select class="form-control {{ $errors->has('show_in_footer') ? 'is-invalid' : '' }}" name="show_in_footer" id="show_in_footer" required>
                            <option value disabled {{ old('show_in_footer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Page::SHOW_IN_FOOTER_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('show_in_footer', $page->show_in_footer) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('show_in_footer'))
                            <span class="text-danger">{{ $errors->first('show_in_footer') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.show_in_footer_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.page.fields.status') }}</label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                            <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Page::STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $page->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.status_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description">{{ trans('cruds.page.fields.description') }}</label>
                        <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $page->description) !!}</textarea>
                        @if($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.description_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="page_image">{{ trans('cruds.page.fields.page_image') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('page_image') ? 'is-invalid' : '' }}" id="page_image-dropzone">
                        </div>
                        @if($errors->has('page_image'))
                            <span class="text-danger">{{ $errors->first('page_image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.page_image_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="slug">{{ trans('cruds.page.fields.slug') }}</label>
                        <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" required>
                        @if($errors->has('slug'))
                            <span class="text-danger">{{ $errors->first('slug') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.slug_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="meta_tag">{{ trans('cruds.page.fields.meta_tag') }}</label>
                        <input class="form-control {{ $errors->has('meta_tag') ? 'is-invalid' : '' }}" type="text" name="meta_tag" id="meta_tag" value="{{ old('meta_tag', $page->meta_tag) }}" required>
                        @if($errors->has('meta_tag'))
                            <span class="text-danger">{{ $errors->first('meta_tag') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.meta_tag_helper') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="meta_title">{{ trans('cruds.page.fields.meta_title') }}</label>
                        <input class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" required>
                        @if($errors->has('meta_title'))
                            <span class="text-danger">{{ $errors->first('meta_title') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.meta_title_helper') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="meta_description">{{ trans('cruds.page.fields.meta_description') }}</label>
                        <textarea class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" name="meta_description" id="meta_description" required>{{ old('meta_description', $page->meta_description) }}</textarea>
                        @if($errors->has('meta_description'))
                            <span class="text-danger">{{ $errors->first('meta_description') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.page.fields.meta_description_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.pages.storeCKEditorImages') }}', true);
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
    url: '{{ route('admin.pages.storeMedia') }}',
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