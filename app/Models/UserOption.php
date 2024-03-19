<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOption extends Model
{
    use HasFactory;

    public $table = 'user_options';

    protected $appends = [
        'option_image',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const OPTION_SEQUENCE_SELECT = [
        '1' => 'A',
        '2' => 'B',
        '3' => 'C',
        '4' => 'D',
        '5' => 'E',
        '6' => 'F',
    ];

    protected $fillable = [
        'question_id',
        'user_id',
        'option_sequence',
        'option_value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
