<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\File;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "schedules";

    protected $fillable = [
        'file_id', 'schedule_due', 'remark', 'position'
    ];

    protected $dates = [
        'schedule_due',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getScheduleDueAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function file()
    {
        return $this->beLongsTo(File::class);
    }
}
