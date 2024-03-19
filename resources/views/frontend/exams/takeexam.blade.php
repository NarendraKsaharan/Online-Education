<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Examination</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .custom-shadow {
        position: relative;
        border-radius: 8px;
    }
    .custom-shadow::before {
        content: "";
        position: absolute;
        top: -5px;
        left: 0;
        width: 100%;
        height: 10px;
        background: rgba(255, 165, 0, 0.7);
        border-radius: 8px 8px 0 0;
        z-index: -1;
    }
    .custom-shadow {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border-radius: 4px;
    }
    .larger-badge {
            font-size: 18px; /* Set the font size to increase the circle size */
            height: 32px; /* Set the height to adjust the circle's height */
            width: 32px; /* Set the width to make the circle equal in height and width */
            border-radius: 50%; /* Make the shape a circle using border-radius */
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
</style>
</head>

<body>
    <div class="header bg-white py-1 text-center shadow">
        <h2 class="text-success">PAREEKSHAK</h2>
        <p class="text-danger">Online Examination Panel</p>
    </div>

    <div class="container mt-1 mb-1 bg-whitesmoke p-2">
        <div>
            <h3 class="text-dark">Quiz</h3>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form id="examForm" action="{{ route('frontend.question-save') }}" method="post">
                @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                    <div class="bg-white p-2 custom-shadow">
                        @php
                            $i = 1;
                        @endphp
                        <div id="questionContainer" class="p-1 overflow-auto" style="max-height: 350px;">
                            @foreach($exam->examQuestions as $index => $question)
                                <div class="question @if($index > 0) d-none @endif">    
                                    <h3 class="mb-2">Question {{ $i++ }}</h3>
                                    <div class="border-bottom border-gray mb-3"></div>
                                        <p class="mb-3"><input type="hidden" name="question_id[]" value="{{ $question->id }}"s>{{ $question->question }}</p>
                                        @php
                                            $j = 1;
                                        @endphp
                                        @foreach($question->questionOptions as $option)
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>
                                                        {{ $j++ }}. <input type="radio" name="answer[]" value="{{ $option->option_value }}">
                                                        {{ $option->option_value }}
                                                    </td>
                                                </tr>
                                            </table>
                                        @endforeach
                                </div>            
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-between border-bottom border-gray pb-3">
                            <button type="button" id="saveBtn" class="btn btn-danger next">Save & Next</button>
                            <button type="button" id="clearBtn" class="btn btn-danger">Clear</button>
                            <button type="button" class="btn btn-warning">Mark For Review</button>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <div>
                                <button type="button" id="backBtn" class="btn btn-primary">Back</button>
                                <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>    
            </div>

            <div class="col-md-4">
                <div class="bg-white p-2 custom-shadow">
                    <div class="container mt-2">
                        <div class="row border-bottom border-gray mb-3">
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-info text-white larger-badge mr-1">0</span> Not Visited
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-danger text-white larger-badge mr-1">0</span> Not Answered
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-success text-white larger-badge mr-1">0</span> Answered
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-warning text-white larger-badge mr-1">0</span> Marked For Review
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-2">
                                <span class="badge bg-info text-white larger-badge mr-1">1</span>
                            </div>
                            <div class="col-md-2 mb-2">
                                <span class="badge bg-info text-white larger-badge mr-1">2</span>
                            </div>
                            <div class="col-md-2 mb-2">
                                <span class="badge bg-info text-white larger-badge mr-1">3</span>
                            </div>
                            <div class="col-md-2 mb-2">
                                <span class="badge bg-info text-white larger-badge mr-1">4</span>
                            </div>
                            <div class="col-md-2 mb-2">
                                <span class="badge bg-info text-white larger-badge mr-1">5</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white mt-4 p-2 custom-shadow">
                    <h4 class="text-danger">Note</h4>
                    <p>Question which are saved and marked for review will be auto submitted at the end of the paper</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JavaScript -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>










<!-- <script>
    $(document).ready(function() {
        $('#examForm button.next').on('click', function(e) {
            e.preventDefault();

            const activeQuestion = $('#questionContainer .question.active');
            if (activeQuestion.length === 0) {
                return;
            }

            const formData = activeQuestion.find('input, select, textarea').serialize();
            const examId = $('[name="exam_id"]').val();
            // alert(examId);
            formData += '&exam_id=' + encodeURIComponent(examId);

            $.ajax({
                url: $('#examForm').attr('action'), 
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, // Include the CSRF token in the request headers
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script> -->







<script>
    document.addEventListener("DOMContentLoaded", function () {
        const questions = document.querySelectorAll(".question");
        let currentQuestion = 0;
        const nextBtn = document.getElementById("nextBtn");
        const backBtn = document.getElementById("backBtn");
        const clearBtn = document.getElementById("clearBtn");

        function showQuestion(index) {
            questions.forEach((question, i) => {
                if (i === index) {
                    question.classList.remove("d-none");
                    question.classList.add("active");
                } else {
                    question.classList.add("d-none");
                    question.classList.remove("active");
                }
            });
        }

        function clearSelectedOption() {
            const selectedOptions = document.querySelectorAll('input[type="radio"]:checked');
            selectedOptions.forEach((option) => {
                option.checked = false;
            });
        }

        nextBtn.addEventListener("click", function () {
            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
                clearSelectedOption();
            }
        });

        backBtn.addEventListener("click", function () {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
                clearSelectedOption();
            }
        });

        clearBtn.addEventListener("click", function () {
            clearSelectedOption();
        });

        showQuestion(currentQuestion);
    });
</script>



<!-- <script>
    $(document).ready(function() {
        $('#examForm button.next').on('click', function(e) {
            e.preventDefault();

            const activeQuestion = $('#questionContainer .question.active');
            if (activeQuestion.length === 0) {
                return;
            }

            const formData = new FormData();

            const serializedFormData = activeQuestion.find('input, select, textarea').serializeArray();
            serializedFormData.forEach((field) => {
                formData.append(field.name, field.value);
            });

            const examId = $('[name="exam_id"]').val();
            formData.append('exam_id', examId);

            $.ajax({
                url: $('#examForm').attr('action'), 
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, 
                contentType: false, 
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, 
                success: function(response) {
                    console.log(response);
                    
                    $.post("{{ route('frontend.question-save') }}", { response: response }, function(data) {
                        console.log(data);
                    }, 'json'); 
                },
                error: function(xhr, status, error) {
                    //console.error(error);
                }
            });
        });
    });
</script> -->



<!-- Assuming you have already loaded jQuery before this script -->
<script>
    $(document).ready(function() {
        // Store the selected options for each question in the DOM
        $('.question').each(function() {
            const questionId = $(this).data('question-id');
            const storedResponse = localStorage.getItem(`question_${questionId}`);
            if (storedResponse) {
                $(this).find('input, select').each(function() {
                    const fieldName = $(this).attr('name');
                    if (storedResponse === fieldName) {
                        $(this).prop('checked', true);
                    }
                });
            }
        });

        $('#examForm button.next').on('click', function(e) {
            e.preventDefault();

            const activeQuestion = $('#questionContainer .question.active');
            if (activeQuestion.length === 0) {
                return;
            }

            const formData = new FormData();

            const serializedFormData = activeQuestion.find('input:checked, select').serializeArray();
            serializedFormData.forEach((field) => {
                formData.append(field.name, field.value);
            });

            const examId = $('[name="exam_id"]').val();
            formData.append('exam_id', examId);

            $.ajax({
                url: $('#examForm').attr('action'), 
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false, 
                contentType: false, 
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, 
                success: function(response) {
                    console.log(response);

                    // Save the response for the current question in localStorage
                    const questionId = activeQuestion.data('question-id');
                    localStorage.setItem(`question_${questionId}`, response);

                    $.post("{{ route('frontend.question-save') }}", { response: response }, function(data) {
                        console.log(data);
                    }, 'json'); 
                },
                error: function(xhr, status, error) {
                    //console.error(error);
                }
            });
        });
    });
</script>












</html>
