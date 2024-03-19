<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'master_access',
            ],
            [
                'id'    => 18,
                'title' => 'student_create',
            ],
            [
                'id'    => 19,
                'title' => 'student_edit',
            ],
            [
                'id'    => 20,
                'title' => 'student_show',
            ],
            [
                'id'    => 21,
                'title' => 'student_delete',
            ],
            [
                'id'    => 22,
                'title' => 'student_access',
            ],
            [
                'id'    => 23,
                'title' => 'manage_content_access',
            ],
            [
                'id'    => 24,
                'title' => 'manage_exam_access',
            ],
            [
                'id'    => 25,
                'title' => 'course_create',
            ],
            [
                'id'    => 26,
                'title' => 'course_edit',
            ],
            [
                'id'    => 27,
                'title' => 'course_show',
            ],
            [
                'id'    => 28,
                'title' => 'course_delete',
            ],
            [
                'id'    => 29,
                'title' => 'course_access',
            ],
            [
                'id'    => 30,
                'title' => 'question_create',
            ],
            [
                'id'    => 31,
                'title' => 'question_edit',
            ],
            [
                'id'    => 32,
                'title' => 'question_show',
            ],
            [
                'id'    => 33,
                'title' => 'question_delete',
            ],
            [
                'id'    => 34,
                'title' => 'question_access',
            ],
            [
                'id'    => 35,
                'title' => 'manage_fee_access',
            ],
            [
                'id'    => 36,
                'title' => 'manage_course_video_access',
            ],
            [
                'id'    => 37,
                'title' => 'course_video_create',
            ],
            [
                'id'    => 38,
                'title' => 'course_video_edit',
            ],
            [
                'id'    => 39,
                'title' => 'course_video_show',
            ],
            [
                'id'    => 40,
                'title' => 'course_video_delete',
            ],
            [
                'id'    => 41,
                'title' => 'course_video_access',
            ],
            [
                'id'    => 42,
                'title' => 'manage_assignment_access',
            ],
            [
                'id'    => 43,
                'title' => 'assignment_create',
            ],
            [
                'id'    => 44,
                'title' => 'assignment_edit',
            ],
            [
                'id'    => 45,
                'title' => 'assignment_show',
            ],
            [
                'id'    => 46,
                'title' => 'assignment_delete',
            ],
            [
                'id'    => 47,
                'title' => 'assignment_access',
            ],
            [
                'id'    => 48,
                'title' => 'assign_assignment_create',
            ],
            [
                'id'    => 49,
                'title' => 'assign_assignment_edit',
            ],
            [
                'id'    => 50,
                'title' => 'assign_assignment_show',
            ],
            [
                'id'    => 51,
                'title' => 'assign_assignment_delete',
            ],
            [
                'id'    => 52,
                'title' => 'assign_assignment_access',
            ],
            [
                'id'    => 53,
                'title' => 'option_create',
            ],
            [
                'id'    => 54,
                'title' => 'option_edit',
            ],
            [
                'id'    => 55,
                'title' => 'option_show',
            ],
            [
                'id'    => 56,
                'title' => 'option_delete',
            ],
            [
                'id'    => 57,
                'title' => 'option_access',
            ],
            [
                'id'    => 58,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 59,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 60,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 61,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 62,
                'title' => 'manage_student_access',
            ],
            [
                'id'    => 63,
                'title' => 'student_address_create',
            ],
            [
                'id'    => 64,
                'title' => 'student_address_edit',
            ],
            [
                'id'    => 65,
                'title' => 'student_address_show',
            ],
            [
                'id'    => 66,
                'title' => 'student_address_delete',
            ],
            [
                'id'    => 67,
                'title' => 'student_address_access',
            ],
            [
                'id'    => 68,
                'title' => 'student_education_create',
            ],
            [
                'id'    => 69,
                'title' => 'student_education_edit',
            ],
            [
                'id'    => 70,
                'title' => 'student_education_show',
            ],
            [
                'id'    => 71,
                'title' => 'student_education_delete',
            ],
            [
                'id'    => 72,
                'title' => 'student_education_access',
            ],
            [
                'id'    => 73,
                'title' => 'country_create',
            ],
            [
                'id'    => 74,
                'title' => 'country_edit',
            ],
            [
                'id'    => 75,
                'title' => 'country_show',
            ],
            [
                'id'    => 76,
                'title' => 'country_delete',
            ],
            [
                'id'    => 77,
                'title' => 'country_access',
            ],
            [
                'id'    => 78,
                'title' => 'state_create',
            ],
            [
                'id'    => 79,
                'title' => 'state_edit',
            ],
            [
                'id'    => 80,
                'title' => 'state_show',
            ],
            [
                'id'    => 81,
                'title' => 'state_delete',
            ],
            [
                'id'    => 82,
                'title' => 'state_access',
            ],
            [
                'id'    => 83,
                'title' => 'city_create',
            ],
            [
                'id'    => 84,
                'title' => 'city_edit',
            ],
            [
                'id'    => 85,
                'title' => 'city_show',
            ],
            [
                'id'    => 86,
                'title' => 'city_delete',
            ],
            [
                'id'    => 87,
                'title' => 'city_access',
            ],
            [
                'id'    => 88,
                'title' => 'plan_create',
            ],
            [
                'id'    => 89,
                'title' => 'plan_edit',
            ],
            [
                'id'    => 90,
                'title' => 'plan_show',
            ],
            [
                'id'    => 91,
                'title' => 'plan_delete',
            ],
            [
                'id'    => 92,
                'title' => 'plan_access',
            ],
            [
                'id'    => 93,
                'title' => 'topic_create',
            ],
            [
                'id'    => 94,
                'title' => 'topic_edit',
            ],
            [
                'id'    => 95,
                'title' => 'topic_show',
            ],
            [
                'id'    => 96,
                'title' => 'topic_delete',
            ],
            [
                'id'    => 97,
                'title' => 'topic_access',
            ],
            [
                'id'    => 98,
                'title' => 'page_create',
            ],
            [
                'id'    => 99,
                'title' => 'page_edit',
            ],
            [
                'id'    => 100,
                'title' => 'page_show',
            ],
            [
                'id'    => 101,
                'title' => 'page_delete',
            ],
            [
                'id'    => 102,
                'title' => 'page_access',
            ],
            [
                'id'    => 103,
                'title' => 'block_create',
            ],
            [
                'id'    => 104,
                'title' => 'block_edit',
            ],
            [
                'id'    => 105,
                'title' => 'block_show',
            ],
            [
                'id'    => 106,
                'title' => 'block_delete',
            ],
            [
                'id'    => 107,
                'title' => 'block_access',
            ],
            [
                'id'    => 108,
                'title' => 'slider_create',
            ],
            [
                'id'    => 109,
                'title' => 'slider_edit',
            ],
            [
                'id'    => 110,
                'title' => 'slider_show',
            ],
            [
                'id'    => 111,
                'title' => 'slider_delete',
            ],
            [
                'id'    => 112,
                'title' => 'slider_access',
            ],
            [
                'id'    => 113,
                'title' => 'fee_create',
            ],
            [
                'id'    => 114,
                'title' => 'fee_edit',
            ],
            [
                'id'    => 115,
                'title' => 'fee_show',
            ],
            [
                'id'    => 116,
                'title' => 'fee_delete',
            ],
            [
                'id'    => 117,
                'title' => 'fee_access',
            ],
            [
                'id'    => 118,
                'title' => 'exam_create',
            ],
            [
                'id'    => 119,
                'title' => 'exam_edit',
            ],
            [
                'id'    => 120,
                'title' => 'exam_show',
            ],
            [
                'id'    => 121,
                'title' => 'exam_delete',
            ],
            [
                'id'    => 122,
                'title' => 'exam_access',
            ],
            [
                'id'    => 123,
                'title' => 'fee_record_show',
            ],
            [
                'id'    => 124,
                'title' => 'fee_record_access',
            ],
            [
                'id'    => 125,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
