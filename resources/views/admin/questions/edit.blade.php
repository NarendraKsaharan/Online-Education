@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.question.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.questions.update", [$question->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="course_id">{{ trans('cruds.question.fields.course') }}</label>
                        <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                            @foreach($courses as $id => $entry)
                                <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $question->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('course'))
                            <span class="text-danger">{{ $errors->first('course') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.course_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="exam_id">{{ trans('cruds.question.fields.exam') }}</label>
                        <select class="form-control select2 {{ $errors->has('exam') ? 'is-invalid' : '' }}" name="exam_id" id="exam_id" required>
                            @foreach($exams as $id => $entry)
                                <option value="{{ $id }}" {{ (old('exam_id') ? old('exam_id') : $question->exam->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('exam'))
                            <span class="text-danger">{{ $errors->first('exam') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.exam_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.question.fields.status') }}</label>
                        <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                            <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Question::STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $question->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.status_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.question.fields.type') }}</label>
                        <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                            <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Question::TYPE_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('type', $question->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type'))
                            <span class="text-danger">{{ $errors->first('type') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.type_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required" for="question">{{ trans('cruds.question.fields.question') }}</label>
                        <textarea class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question" id="question" required>{{ old('question', $question->question) }}</textarea>
                        @if($errors->has('question'))
                            <span class="text-danger">{{ $errors->first('question') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.question_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">{{ trans('cruds.question.fields.image') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                        </div>
                        @if($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.image_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="required">{{ trans('cruds.question.fields.answer') }}</label>
                        <select class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" name="answer" id="answer" required>
                            <option value disabled {{ old('answer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Question::ANSWER_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('answer', $question->answer) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('answer'))
                            <span class="text-danger">{{ $errors->first('answer') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.answer_helper') }}</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="answer_image">{{ trans('cruds.question.fields.answer_image') }}</label>
                        <div class="needsclick dropzone {{ $errors->has('answer_image') ? 'is-invalid' : '' }}" id="answer_image-dropzone">
                        </div>
                        @if($errors->has('answer_image'))
                            <span class="text-danger">{{ $errors->first('answer_image') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.question.fields.answer_image_helper') }}</span>
                    </div>
                </div>

            </div>
            <!-- row-end-->

            <!-- option-data -->    
            <!-- <div class="form-group">
              <label for="option">Add Option</label>
              <div class="row">
                  <div class="col-md-12">
                      <div class="table-responsive">
                            <table class="table table-bordered" id="table-add-more">
                                <tr>
                                    <th>Option Sequence</th>
                                    <th>Option Value</th>
                                    <th>Option Image</th>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                    <select name="option_sequence[]" id="option_sequence" class="form-control" readonly>
                                        <option value="1">A</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="option_value[]" id="option_value" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="option_image[]" id="option_image" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                    <select name="option_sequence[]" id="option_sequence" class="form-control" readonly>
                                        <option value="2">B</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="option_value[]" id="option_value" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="option_image[]" id="option_image" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                    <select name="option_sequence[]" id="option_sequence" class="form-control" readonly>
                                        <option value="3">C</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="option_value[]" id="option_value" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="option_image[]" id="option_image" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                    <select name="option_sequence[]" id="option_sequence" class="form-control" readonly>
                                        <option value="4">D</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="option_value[]" id="option_value" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="option_image[]" id="option_image" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                    <select name="option_sequence[]" id="option_sequence" class="form-control" readonly>
                                        <option value="6">F</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="option_value[]" id="option_value" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="option_image[]" id="option_image" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-4">
                                    <select name="option_sequence[]" id="option_sequence" class="form-control" readonly>
                                        <option value="6">E</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="text" name="option_value[]" id="option_value" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="option_image[]" id="option_image" class="form-control" multiple>
                                    </td>
                                </tr>
                          </table>
                      </div>
                  </div>
              </div>
            </div> -->
            <!-- option-data-end -->


            
                <!-- Option Data -->
                <div class="form-group">
                    <label for="option">Add Option</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="table-add-more">
                                    <tr>
                                        <th>Option Sequence</th>
                                        <th>Option Value</th>
                                        <th>Option Image</th>
                                    </tr>
                                    @foreach ($options as $option)
                                    <tr>
                                        <td class="col-md-4">
                                            <input type="hidden" name="option_id[]" value="{{ $option->id }}">
                                            <select name="option_sequence[]" class="form-control" readonly>
                                                <option value="{{ $option->option_sequence }}" selected>{{ $option->option_sequence }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="option_value[]" class="form-control" value="{{ $option->option_value }}">
                                        </td>
                                        <td>
                                        @if($option->getFirstMediaUrl('option_image'))
                                                <div class="form-check mt-3">
                                                    <input type="checkbox" class="form-check-input" name="delete_image[]" value="{{ $option->getFirstMedia('option_image')->id }}" id="delete_image" checked>
                                                    <label class="form-check-label" for="delete_image">Delete Image</label>
                                                </div> 
                                                <img src="{{ $option->getFirstMediaUrl('option_image') }}" alt="Wrong">
                                        @endif    
                                            <input type="file" name="option_image[]" class="form-control">
                                        </td>
                                    </tr>
                                    @endforeach

                                    <!-- Add empty rows for new options (total of 6 rows) -->
                                    @php
                                        $existingOptionCount = count($options);
                                        $emptyRowCount = max(6 - $existingOptionCount, 0);
                                    @endphp

                                    @for ($i = 0; $i < $emptyRowCount; $i++)
                                    <tr>
                                        <td class="col-md-4">
                                            <select name="option_sequence[]" class="form-control" readonly>
                                                <option value="{{ $existingOptionCount + $i + 1 }}">{{ $existingOptionCount + $i + 1 }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="option_value[]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="file" name="option_image[]" class="form-control">
                                        </td>
                                    </tr>
                                    @endfor
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Option Data End -->





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
$(document).ready(function() {
  $("#type").on("change", function() {
    selType = $(this).val();
    if (selType === "1" || selType === "2") {
      $(".hide-option-data").show();
    } else if (selType === "3") {
      $(".hide-option-data").hide();
    }
  });
});
</script>

<script>
    $(document).ready(function(){
        $('#course_id').select2();

        $('#course_id').on('select2:select', function(){
            courseId = $(this).val();
            // alert(courseId);

            $.ajax({
                url: "{{route('admin.get-exam')}}",
                method: 'GET',
                data: {'course_id': courseId},
                success: function(res) {
                    // console.log("sbdchjbsdhjcbsdk");
                    $('#exam_id').html(res);
                },
                error: function(re) {
                    alert("Something went wrong with your JS code...");
                }
            });
        });
    });
</script>

<script>
    var uploadedImageMap = {}
Dropzone.options.imageDropzone = {
    url: '{{ route('admin.questions.storeMedia') }}',
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
@if(isset($question) && $question->image)
      var files = {!! json_encode($question->image) !!}
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
    var uploadedAnswerImageMap = {}
Dropzone.options.answerImageDropzone = {
    url: '{{ route('admin.questions.storeMedia') }}',
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
      $('form').append('<input type="hidden" name="answer_image[]" value="' + response.name + '">')
      uploadedAnswerImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAnswerImageMap[file.name]
      }
      $('form').find('input[name="answer_image[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($question) && $question->answer_image)
      var files = {!! json_encode($question->answer_image) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="answer_image[]" value="' + file.file_name + '">')
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