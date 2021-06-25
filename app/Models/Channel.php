<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    protected $fillable = [
        'name', 'detial'
    ];

    public function files()
    {
        return $this->beLongsToMany(File::class, 'channel_file', 'file_id', 'channel_id');
    }
}
