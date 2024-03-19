<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public $table = 'countries';

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
        'name',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function countryStates()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }

    public function countryCities()
    {
        return $this->hasMany(City::class, 'country_id', 'id');
    }

    public function countryStudentAddresses()
    {
        return $this->hasMany(StudentAddress::class, 'country_id', 'id');
    }
}
