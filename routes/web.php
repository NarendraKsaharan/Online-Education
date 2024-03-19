<?php

Route::view('/', 'welcome');
Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Student
    Route::delete('students/destroy', 'StudentController@massDestroy')->name('students.massDestroy');
    Route::post('students/media', 'StudentController@storeMedia')->name('students.storeMedia');
    Route::post('students/ckmedia', 'StudentController@storeCKEditorImages')->name('students.storeCKEditorImages');
    Route::resource('students', 'StudentController');

    // Course
    Route::delete('courses/destroy', 'CourseController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CourseController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CourseController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::resource('courses', 'CourseController');

    // Question
    Route::delete('questions/destroy', 'QuestionController@massDestroy')->name('questions.massDestroy');
    Route::post('questions/media', 'QuestionController@storeMedia')->name('questions.storeMedia');
    Route::post('questions/ckmedia', 'QuestionController@storeCKEditorImages')->name('questions.storeCKEditorImages');
    Route::resource('questions', 'QuestionController');

    // Course Video
    Route::delete('course-videos/destroy', 'CourseVideoController@massDestroy')->name('course-videos.massDestroy');
    Route::post('course-videos/media', 'CourseVideoController@storeMedia')->name('course-videos.storeMedia');
    Route::post('course-videos/ckmedia', 'CourseVideoController@storeCKEditorImages')->name('course-videos.storeCKEditorImages');
    Route::resource('course-videos', 'CourseVideoController');

    // Assignment
    Route::delete('assignments/destroy', 'AssignmentController@massDestroy')->name('assignments.massDestroy');
    Route::post('assignments/media', 'AssignmentController@storeMedia')->name('assignments.storeMedia');
    Route::post('assignments/ckmedia', 'AssignmentController@storeCKEditorImages')->name('assignments.storeCKEditorImages');
    Route::resource('assignments', 'AssignmentController');

    // Assign Assignment
    Route::delete('assign-assignments/destroy', 'AssignAssignmentController@massDestroy')->name('assign-assignments.massDestroy');
    Route::get('get-assignment', 'AssignAssignmentController@getAssignment')->name('get-assignment');
    Route::resource('assign-assignments', 'AssignAssignmentController');

    // Option
    Route::delete('options/destroy', 'OptionController@massDestroy')->name('options.massDestroy');
    Route::post('options/media', 'OptionController@storeMedia')->name('options.storeMedia');
    Route::post('options/ckmedia', 'OptionController@storeCKEditorImages')->name('options.storeCKEditorImages');
    Route::resource('options', 'OptionController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Student Address
    Route::delete('student-addresses/destroy', 'StudentAddressController@massDestroy')->name('student-addresses.massDestroy');
    Route::resource('student-addresses', 'StudentAddressController');

    // Student Education
    Route::delete('student-educations/destroy', 'StudentEducationController@massDestroy')->name('student-educations.massDestroy');
    Route::resource('student-educations', 'StudentEducationController');

    // Country
    Route::delete('countries/destroy', 'CountryController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountryController');

    // State
    Route::delete('states/destroy', 'StateController@massDestroy')->name('states.massDestroy');
    Route::get('get-state', 'StateController@getState')->name('get-state');
    Route::resource('states', 'StateController');

    // City
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CityController');

    // Plan
    Route::delete('plans/destroy', 'PlanController@massDestroy')->name('plans.massDestroy');
    Route::resource('plans', 'PlanController');

    // Topic
    Route::delete('topics/destroy', 'TopicController@massDestroy')->name('topics.massDestroy');
    Route::resource('topics', 'TopicController');

    // Page
    Route::delete('pages/destroy', 'PageController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PageController@storeMedia')->name('pages.storeMedia');
    Route::post('pages/ckmedia', 'PageController@storeCKEditorImages')->name('pages.storeCKEditorImages');
    Route::resource('pages', 'PageController');

    // Block
    Route::delete('blocks/destroy', 'BlockController@massDestroy')->name('blocks.massDestroy');
    Route::post('blocks/media', 'BlockController@storeMedia')->name('blocks.storeMedia');
    Route::post('blocks/ckmedia', 'BlockController@storeCKEditorImages')->name('blocks.storeCKEditorImages');
    Route::resource('blocks', 'BlockController');

    // Slider
    Route::delete('sliders/destroy', 'SliderController@massDestroy')->name('sliders.massDestroy');
    Route::post('sliders/media', 'SliderController@storeMedia')->name('sliders.storeMedia');
    Route::post('sliders/ckmedia', 'SliderController@storeCKEditorImages')->name('sliders.storeCKEditorImages');
    Route::resource('sliders', 'SliderController');

    // Fee
    Route::delete('fees/destroy', 'FeeController@massDestroy')->name('fees.massDestroy');
    Route::get('add-fee', 'FeeController@addFee')->name('add-fee');
    Route::get('fee-record', 'FeeController@feeRecord')->name('fee-record');
    Route::get('get-student', 'FeeController@getStudent')->name('get-student');
    // Route::get('/fee/{id}', 'FeeController@show')->name('fee.show');
    Route::resource('fees', 'FeeController');

    // Exam
    Route::delete('exams/destroy', 'ExamController@massDestroy')->name('exams.massDestroy');
    Route::get('get-exam', 'ExamController@getExam')->name('get-exam');
    Route::resource('exams', 'ExamController');

    // Fee Record
    Route::resource('fee-records', 'FeeRecordController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
        Route::post('profile/two-factor', 'ChangePasswordController@toggleTwoFactor')->name('password.toggleTwoFactor');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth', '2fa']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Student
    Route::delete('students/destroy', 'StudentController@massDestroy')->name('students.massDestroy');
    Route::post('students/media', 'StudentController@storeMedia')->name('students.storeMedia');
    Route::post('students/ckmedia', 'StudentController@storeCKEditorImages')->name('students.storeCKEditorImages');
    Route::resource('students', 'StudentController');

    // Course
    Route::delete('courses/destroy', 'CourseController@massDestroy')->name('courses.massDestroy');
    Route::post('courses/media', 'CourseController@storeMedia')->name('courses.storeMedia');
    Route::post('courses/ckmedia', 'CourseController@storeCKEditorImages')->name('courses.storeCKEditorImages');
    Route::resource('courses', 'CourseController');

    // Question
    Route::delete('questions/destroy', 'QuestionController@massDestroy')->name('questions.massDestroy');
    Route::post('questions/media', 'QuestionController@storeMedia')->name('questions.storeMedia');
    Route::post('questions/ckmedia', 'QuestionController@storeCKEditorImages')->name('questions.storeCKEditorImages');
    Route::post('question-save', 'QuestionController@questionSave')->name('question-save');
    Route::resource('questions', 'QuestionController');

    // Course Video
    Route::delete('course-videos/destroy', 'CourseVideoController@massDestroy')->name('course-videos.massDestroy');
    Route::post('course-videos/media', 'CourseVideoController@storeMedia')->name('course-videos.storeMedia');
    Route::post('course-videos/ckmedia', 'CourseVideoController@storeCKEditorImages')->name('course-videos.storeCKEditorImages');
    Route::resource('course-videos', 'CourseVideoController');

    // Assignment
    Route::delete('assignments/destroy', 'AssignmentController@massDestroy')->name('assignments.massDestroy');
    Route::post('assignments/media', 'AssignmentController@storeMedia')->name('assignments.storeMedia');
    Route::post('assignments/ckmedia', 'AssignmentController@storeCKEditorImages')->name('assignments.storeCKEditorImages');
    Route::resource('assignments', 'AssignmentController');

    // Assign Assignment
    Route::delete('assign-assignments/destroy', 'AssignAssignmentController@massDestroy')->name('assign-assignments.massDestroy');
    Route::resource('assign-assignments', 'AssignAssignmentController');

    // Option
    Route::delete('options/destroy', 'OptionController@massDestroy')->name('options.massDestroy');
    Route::post('options/media', 'OptionController@storeMedia')->name('options.storeMedia');
    Route::post('options/ckmedia', 'OptionController@storeCKEditorImages')->name('options.storeCKEditorImages');
    Route::resource('options', 'OptionController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Student Address
    Route::delete('student-addresses/destroy', 'StudentAddressController@massDestroy')->name('student-addresses.massDestroy');
    Route::resource('student-addresses', 'StudentAddressController');

    // Student Education
    Route::delete('student-educations/destroy', 'StudentEducationController@massDestroy')->name('student-educations.massDestroy');
    Route::resource('student-educations', 'StudentEducationController');

    // Country
    Route::delete('countries/destroy', 'CountryController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountryController');

    // State
    Route::delete('states/destroy', 'StateController@massDestroy')->name('states.massDestroy');
    Route::resource('states', 'StateController');

    // City
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::resource('cities', 'CityController');

    // Plan
    Route::delete('plans/destroy', 'PlanController@massDestroy')->name('plans.massDestroy');
    Route::resource('plans', 'PlanController');

    // Topic
    Route::delete('topics/destroy', 'TopicController@massDestroy')->name('topics.massDestroy');
    Route::resource('topics', 'TopicController');

    // Page
    Route::delete('pages/destroy', 'PageController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PageController@storeMedia')->name('pages.storeMedia');
    Route::post('pages/ckmedia', 'PageController@storeCKEditorImages')->name('pages.storeCKEditorImages');
    Route::resource('pages', 'PageController');

    // Block
    Route::delete('blocks/destroy', 'BlockController@massDestroy')->name('blocks.massDestroy');
    Route::post('blocks/media', 'BlockController@storeMedia')->name('blocks.storeMedia');
    Route::post('blocks/ckmedia', 'BlockController@storeCKEditorImages')->name('blocks.storeCKEditorImages');
    Route::resource('blocks', 'BlockController');

    // Slider
    Route::delete('sliders/destroy', 'SliderController@massDestroy')->name('sliders.massDestroy');
    Route::post('sliders/media', 'SliderController@storeMedia')->name('sliders.storeMedia');
    Route::post('sliders/ckmedia', 'SliderController@storeCKEditorImages')->name('sliders.storeCKEditorImages');
    Route::resource('sliders', 'SliderController');

    // Fee
    Route::delete('fees/destroy', 'FeeController@massDestroy')->name('fees.massDestroy');
    Route::get('fee-record', 'FeeController@feeRecord')->name('fee-record');
    Route::resource('fees', 'FeeController');

    // Exam
    Route::delete('exams/destroy', 'ExamController@massDestroy')->name('exams.massDestroy');
    Route::get('take-exam', 'ExamController@takeExam')->name('take-exam');
    Route::resource('exams', 'ExamController');

    // Fee Record
    Route::resource('fee-records', 'FeeRecordController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/toggle-two-factor', 'ProfileController@toggleTwoFactor')->name('profile.toggle-two-factor');
});
Route::group(['namespace' => 'Auth', 'middleware' => ['auth', '2fa']], function () {
    // Two Factor Authentication
    if (file_exists(app_path('Http/Controllers/Auth/TwoFactorController.php'))) {
        Route::get('two-factor', 'TwoFactorController@show')->name('twoFactor.show');
        Route::post('two-factor', 'TwoFactorController@check')->name('twoFactor.check');
        Route::get('two-factor/resend', 'TwoFactorController@resend')->name('twoFactor.resend');
    }
});
