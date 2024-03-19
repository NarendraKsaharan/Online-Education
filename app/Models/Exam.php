<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    public $table = 'exams';

    public const STATUS_SELECT = [
        '1' => 'Enable',
        '2' => 'Disable',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'course_id',
        'title',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function examQuestions()
    {
        return $this->hasMany(Question::class, 'exam_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }
}
