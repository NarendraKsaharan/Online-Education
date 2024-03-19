<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Student
    Route::post('students/media', 'StudentApiController@storeMedia')->name('students.storeMedia');
    Route::apiResource('students', 'StudentApiController');

    // Course
    Route::post('courses/media', 'CourseApiController@storeMedia')->name('courses.storeMedia');
    Route::apiResource('courses', 'CourseApiController');

    // Question
    Route::post('questions/media', 'QuestionApiController@storeMedia')->name('questions.storeMedia');
    Route::apiResource('questions', 'QuestionApiController');

    // Course Video
    Route::post('course-videos/media', 'CourseVideoApiController@storeMedia')->name('course-videos.storeMedia');
    Route::apiResource('course-videos', 'CourseVideoApiController');

    // Assignment
    Route::post('assignments/media', 'AssignmentApiController@storeMedia')->name('assignments.storeMedia');
    Route::apiResource('assignments', 'AssignmentApiController');

    // Assign Assignment
    Route::apiResource('assign-assignments', 'AssignAssignmentApiController');

    // Option
    Route::post('options/media', 'OptionApiController@storeMedia')->name('options.storeMedia');
    Route::apiResource('options', 'OptionApiController');

    // Student Address
    Route::apiResource('student-addresses', 'StudentAddressApiController');

    // Student Education
    Route::apiResource('student-educations', 'StudentEducationApiController');

    // Country
    Route::apiResource('countries', 'CountryApiController');

    // State
    Route::apiResource('states', 'StateApiController');

    // City
    Route::apiResource('cities', 'CityApiController');

    // Plan
    Route::apiResource('plans', 'PlanApiController');

    // Topic
    Route::apiResource('topics', 'TopicApiController');

    // Page
    Route::post('pages/media', 'PageApiController@storeMedia')->name('pages.storeMedia');
    Route::apiResource('pages', 'PageApiController');

    // Block
    Route::post('blocks/media', 'BlockApiController@storeMedia')->name('blocks.storeMedia');
    Route::apiResource('blocks', 'BlockApiController');

    // Slider
    Route::post('sliders/media', 'SliderApiController@storeMedia')->name('sliders.storeMedia');
    Route::apiResource('sliders', 'SliderApiController');

    // Fee
    Route::apiResource('fees', 'FeeApiController');

    // Exam
    Route::apiResource('exams', 'ExamApiController');

    // Fee Record
    Route::apiResource('fee-records', 'FeeRecordApiController', ['except' => ['store', 'update', 'destroy']]);
});
