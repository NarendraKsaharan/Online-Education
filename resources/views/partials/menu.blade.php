<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs("admin.home") ? "active" : "" }}" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/permissions*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/users*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('master_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/courses*") ? "menu-open" : "" }} {{ request()->is("admin/countries*") ? "menu-open" : "" }} {{ request()->is("admin/states*") ? "menu-open" : "" }} {{ request()->is("admin/cities*") ? "menu-open" : "" }} {{ request()->is("admin/plans*") ? "menu-open" : "" }} {{ request()->is("admin/topics*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/courses*") ? "active" : "" }} {{ request()->is("admin/countries*") ? "active" : "" }} {{ request()->is("admin/states*") ? "active" : "" }} {{ request()->is("admin/cities*") ? "active" : "" }} {{ request()->is("admin/plans*") ? "active" : "" }} {{ request()->is("admin/topics*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-th-list">

                            </i>
                            <p>
                                {{ trans('cruds.master.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('course_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.courses.index") }}" class="nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-graduation-cap">

                                        </i>
                                        <p>
                                            {{ trans('cruds.course.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('country_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.countries.index") }}" class="nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.country.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('state_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.states.index") }}" class="nav-link {{ request()->is("admin/states") || request()->is("admin/states/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.state.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('city_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.cities.index") }}" class="nav-link {{ request()->is("admin/cities") || request()->is("admin/cities/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.city.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('plan_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.plans.index") }}" class="nav-link {{ request()->is("admin/plans") || request()->is("admin/plans/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.plan.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('topic_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.topics.index") }}" class="nav-link {{ request()->is("admin/topics") || request()->is("admin/topics/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.topic.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage_content_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/pages*") ? "menu-open" : "" }} {{ request()->is("admin/blocks*") ? "menu-open" : "" }} {{ request()->is("admin/sliders*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/pages*") ? "active" : "" }} {{ request()->is("admin/blocks*") ? "active" : "" }} {{ request()->is("admin/sliders*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-book-open">

                            </i>
                            <p>
                                {{ trans('cruds.manageContent.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('page_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.pages.index") }}" class="nav-link {{ request()->is("admin/pages") || request()->is("admin/pages/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.page.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('block_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.blocks.index") }}" class="nav-link {{ request()->is("admin/blocks") || request()->is("admin/blocks/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.block.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('slider_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.sliders.index") }}" class="nav-link {{ request()->is("admin/sliders") || request()->is("admin/sliders/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.slider.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage_exam_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/questions*") ? "menu-open" : "" }} {{ request()->is("admin/options*") ? "menu-open" : "" }} {{ request()->is("admin/exams*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/questions*") ? "active" : "" }} {{ request()->is("admin/options*") ? "active" : "" }} {{ request()->is("admin/exams*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-align-justify">

                            </i>
                            <p>
                                {{ trans('cruds.manageExam.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('question_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.questions.index") }}" class="nav-link {{ request()->is("admin/questions") || request()->is("admin/questions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-question-circle">

                                        </i>
                                        <p>
                                            {{ trans('cruds.question.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('option_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.options.index") }}" class="nav-link {{ request()->is("admin/options") || request()->is("admin/options/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-outdent">

                                        </i>
                                        <p>
                                            {{ trans('cruds.option.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('exam_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.exams.index") }}" class="nav-link {{ request()->is("admin/exams") || request()->is("admin/exams/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.exam.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage_fee_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/fees*") ? "menu-open" : "" }} {{ request()->is("admin/fee-records*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/fees*") ? "active" : "" }} {{ request()->is("admin/fee-records*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon far fa-credit-card">

                            </i>
                            <p>
                                {{ trans('cruds.manageFee.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('fee_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.add-fee") }}" class="nav-link {{ request()->is("admin/fees") || request()->is("admin/fees/*") ? "active" : "" }}">
                                    <i class="fa-fw nav-icon fas fa-cogs">

                                    </i>
                                    <p>
                                        Add Fee
                                    </p>
                                </a>
                            </li>
                            @endcan
                            @can('fee_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.fees.index") }}" class="nav-link {{ request()->is("admin/fees") || request()->is("admin/fees/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.fee.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('fee_record_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.fee-record") }}" class="nav-link {{ request()->is("admin/fee-records") || request()->is("admin/fee-records/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.feeRecord.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage_course_video_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/course-videos*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/course-videos*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fab fa-youtube">

                            </i>
                            <p>
                                {{ trans('cruds.manageCourseVideo.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('course_video_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.course-videos.index") }}" class="nav-link {{ request()->is("admin/course-videos") || request()->is("admin/course-videos/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-video">

                                        </i>
                                        <p>
                                            {{ trans('cruds.courseVideo.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('manage_assignment_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/assignments*") ? "menu-open" : "" }} {{ request()->is("admin/assign-assignments*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/assignments*") ? "active" : "" }} {{ request()->is("admin/assign-assignments*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon far fa-building">

                            </i>
                            <p>
                                {{ trans('cruds.manageAssignment.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('assignment_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assignments.index") }}" class="nav-link {{ request()->is("admin/assignments") || request()->is("admin/assignments/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-building">

                                        </i>
                                        <p>
                                            {{ trans('cruds.assignment.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('assign_assignment_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.assign-assignments.index") }}" class="nav-link {{ request()->is("admin/assign-assignments") || request()->is("admin/assign-assignments/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-spinner">

                                        </i>
                                        <p>
                                            {{ trans('cruds.assignAssignment.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('user_alert_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.user-alerts.index") }}" class="nav-link {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-bell">

                            </i>
                            <p>
                                {{ trans('cruds.userAlert.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('manage_student_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/students*") ? "menu-open" : "" }} {{ request()->is("admin/student-addresses*") ? "menu-open" : "" }} {{ request()->is("admin/student-educations*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle {{ request()->is("admin/students*") ? "active" : "" }} {{ request()->is("admin/student-addresses*") ? "active" : "" }} {{ request()->is("admin/student-educations*") ? "active" : "" }}" href="#">
                            <i class="fa-fw nav-icon fas fa-user-graduate">

                            </i>
                            <p>
                                {{ trans('cruds.manageStudent.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('student_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.students.index") }}" class="nav-link {{ request()->is("admin/students") || request()->is("admin/students/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user-graduate">

                                        </i>
                                        <p>
                                            {{ trans('cruds.student.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('student_address_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.student-addresses.index") }}" class="nav-link {{ request()->is("admin/student-addresses") || request()->is("admin/student-addresses/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-home">

                                        </i>
                                        <p>
                                            {{ trans('cruds.studentAddress.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('student_education_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.student-educations.index") }}" class="nav-link {{ request()->is("admin/student-educations") || request()->is("admin/student-educations/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-university">

                                        </i>
                                        <p>
                                            {{ trans('cruds.studentEducation.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>