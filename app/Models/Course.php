<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Course extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    public $table = 'courses';

    protected $appends = [
        'image',
        'pdf',
    ];

    public const STATUS_SELECT = [
        '1' => 'Enable',
        '2' => 'Disable',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const FEE_TYPE_SELECT = [
        '1' => 'monthly',
        '2' => 'fixed',
    ];

    protected $fillable = [
        'title',
        'status',
        'description',
        'fee',
        'fee_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function courseCourseVideos()
    {
        return $this->hasMany(CourseVideo::class, 'course_id', 'id');
    }

    public function courseAssignments()
    {
        return $this->hasMany(Assignment::class, 'course_id', 'id');
    }

    public function courseAssignAssignments()
    {
        return $this->hasMany(AssignAssignment::class, 'course_id', 'id');
    }

    public function coursePlans()
    {
        return $this->hasMany(Plan::class, 'course_id', 'id');
    }

    public function courseTopics()
    {
        return $this->hasMany(Topic::class, 'course_id', 'id');
    }

    public function courseExams()
    {
        return $this->hasMany(Exam::class, 'course_id', 'id');
    }

    public function courseQuestions()
    {
        return $this->hasMany(Question::class, 'course_id', 'id');
    }

    public function courseFees()
    {
        return $this->hasMany(Fee::class, 'course_id', 'id');
    }

    public function courseStudents()
    {
        return $this->belongsToMany(Student::class);
    }

    public function courseFeeRecords()
    {
        return $this->belongsToMany(FeeRecord::class);
    }

    public function getImageAttribute()
    {
        $files = $this->getMedia('image');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function getPdfAttribute()
    {
        return $this->getMedia('pdf');
    }
}
