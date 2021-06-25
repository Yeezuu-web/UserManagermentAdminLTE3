<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayFile extends Model
{
    use HasFactory;

    protected $table = 'day_file';

    protected $fillable = [
        'position_order',
        'schedule_on',
    ];

    protected $dates = [
        'schedule_on',
        'created_at',
        'updated_at',
    ];

    public function getScheduleOnAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setScheduleOnAttribute($value)
    {
        $this->attributes['schedule_on'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }

}
