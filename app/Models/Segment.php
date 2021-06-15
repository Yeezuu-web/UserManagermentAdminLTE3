<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Segment extends Model
{
    use HasFactory;

    protected $table = 'segments';

    protected $fillable = [ 'name' ];

    public function files(){
        return $this->beLongsToMany(File::class, 'file_segment_pivot', 'file_id', 'segment_id')
        ->withPivot(['som', 'eom']);
    }
}
