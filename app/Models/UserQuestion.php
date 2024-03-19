<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserQuestion extends Model
{
    use HasFactory;

    public const STATUS_SELECT = [
        '1' => 'Enable',
        '2' => 'Disable',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        '1' => 'Single Select',
        '2' => 'Multi Select',
        '3' => 'Written',
    ];

    public const ANSWER_SELECT = [
        '1' => 'A',
        '2' => 'B',
        '3' => 'C',
        '4' => 'D',
        '5' => 'E',
        '6' => 'F',
    ];

    protected $fillable = [
        'course_id',
        'exam_id',
        'user_id',
        // 'status',
        // 'type',
        'question',
        'answer',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}
