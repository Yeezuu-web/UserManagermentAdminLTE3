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
        return $value ? Carbon::parse($value)->format(config('panel.date_format_ydm')) : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function file()
    {
        return $this->beLongsTo(File::class);
    }

    // public static function boot(){
    //     parent::boot();

    //     static::creating(function($schedule) {
    //         if (is_null($schedule->position)) {
    //             $schedule->position = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)->max('position') + 1;
    //             // dd($schedule->position);
    //             return;
    //         }
    
    //         $lowerPrioritySchedules = Schedule::where('position', '>=', $schedule->position)
    //             ->whereDate('schedule_due', '=', $schedule->schedule_due)
    //             ->get();
    
    //         foreach ($lowerPrioritySchedules as $lowerPrioritySchedule) {
    //             $lowerPrioritySchedule->position++;
    //             $lowerPrioritySchedule->saveQuietly();
    //         }
    //     });
        
    //     static::updating(function($schedule) {
    //         if ($schedule->isClean('position')) {
    //             return;
    //         }
    
    //         if (is_null($schedule->position)) {
    //             $schedule->position = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)->max('position');
    //         }
    
    //         if ($schedule->getOriginal('position') > $schedule->position) {
    //             $positionRange = [
    //                 $schedule->position, $schedule->getOriginal('position')
    //             ];
    //         } else {
    //             $positionRange = [
    //                 $schedule->getOriginal('position'), $schedule->position
    //             ];
    //         }
    
    //         $lowerPrioritySchedules = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)
    //             ->whereBetween('position', $positionRange)
    //             ->where('id', '!=', $schedule->id)
    //             ->get();
    
    //         foreach ($lowerPrioritySchedules as $lowerPrioritySchedule) {
    //             if ($schedule->getOriginal('position') < $schedule->position) {
    //                 $lowerPrioritySchedule->position--;
    //             } else {
    //                 $lowerPrioritySchedule->position++;
    //             }
    //             $lowerPrioritySchedule->saveQuietly();
    //         }
    //     });

    //     static::deleting(function($schedule){
    //         $lowerPrioritySchedules = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)
    //         ->where('position', '>', $schedule->position)
    //         ->get();

    //         foreach ($lowerPrioritySchedules as $lowerPrioritySchedule) {
    //             $lowerPrioritySchedule->position--;
    //             $lowerPrioritySchedule->saveQuietly();
    //         }
    //     });
    // }
}
