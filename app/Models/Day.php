<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';

    protected $fillable = [
        'schedule_on'
    ];

    public function files()
    {
        return $this->beLongsToMany(File::class)
        ->withTimestamps()
        ->withPivot(['position_order']);
    }
}
