<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Student extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    public $table = 'students';

    protected $appends = [
        'profile_image',
    ];

    public const GENDER_RADIO = [
        '1' => 'Male',
        '2' => 'Female',
        '3' => 'Others',
    ];

    protected $dates = [
        'join_date',
        'leave_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'gender',
        'join_date',
        'leave_date',
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

    public function studentStudentAddresses()
    {
        return $this->hasMany(StudentAddress::class, 'student_id', 'id');
    }

    public function studentFees()
    {
        return $this->hasMany(Fee::class, 'student_id', 'id');
    }

    public function studentStudentEducations()
    {
        return $this->hasMany(StudentEducation::class, 'student_id', 'id');
    }

    public function studentAssignments()
    {
        return $this->belongsToMany(Assignment::class);
    }

    public function studentAssignAssignments()
    {
        return $this->belongsToMany(AssignAssignment::class);
    }

    public function studentFeeRecords()
    {
        return $this->belongsToMany(FeeRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function getProfileImageAttribute()
    {
        $file = $this->getMedia('profile_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getJoinDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setJoinDateAttribute($value)
    {
        $this->attributes['join_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getLeaveDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setLeaveDateAttribute($value)
    {
        $this->attributes['leave_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
