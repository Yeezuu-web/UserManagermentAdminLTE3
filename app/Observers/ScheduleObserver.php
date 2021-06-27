<?php

namespace App\Observers;

use App\Models\Schedule;

class ScheduleObserver
{
    /**
     * Handle the Schedule "created" event.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return void
     */
    public function creating(Schedule $schedule)
    {
        if (is_null($schedule->position)) {
            $schedule->position = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)->max('position') + 1;
            // dd($schedule->position);
            return;
        }

        $lowerPrioritySchedules = Schedule::where('position', '>=', $schedule->position)
            ->whereDate('schedule_due', '=', $schedule->schedule_due)
            ->get();

        foreach ($lowerPrioritySchedules as $lowerPrioritySchedule) {
            $lowerPrioritySchedule->position++;
            $lowerPrioritySchedule->saveQuietly();
        }
    }

    public function updating(Schedule $schedule)
    {
        if ($schedule->isClean('position')) {
            return;
        }

        if (is_null($schedule->position)) {
            $schedule->position = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)->max('position');
        }

        if ($schedule->getOriginal('position') > $schedule->position) {
            $positionRange = [
                $schedule->position, $schedule->getOriginal('position')
            ];
        } else {
            $positionRange = [
                $schedule->getOriginal('position'), $schedule->position
            ];
        }

        $lowerPrioritySchedules = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)
            ->whereBetween('position', $positionRange)
            ->where('id', '!=', $schedule->id)
            ->get();

        foreach ($lowerPrioritySchedules as $lowerPrioritySchedule) {
            if ($schedule->getOriginal('position') < $schedule->position) {
                $lowerPrioritySchedule->position--;
            } else {
                $lowerPrioritySchedule->position++;
            }
            $lowerPrioritySchedule->saveQuietly();
        }
    }

    public function deleted(Schedule $schedule)
    {
        $lowerPrioritySchedules = Schedule::whereDate('schedule_due', '=', $schedule->schedule_due)
            ->where('position', '>', $schedule->position)
            ->get();

        foreach ($lowerPrioritySchedules as $lowerPrioritySchedule) {
            $lowerPrioritySchedule->position--;
            $lowerPrioritySchedule->saveQuietly();
        }
    }
}