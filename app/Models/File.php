<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use \DateTimeInterface;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable;

    public const CHANNEL_SELECT = [
        '1' => 'CTN', '2' => 'MYTV', '3' => 'CNC', '4' => 'DIGITAL'
    ];

    public const TYPE_SELECT = [
        'FTA' => 'FTA (Free-To-Air)', 'OTT' => 'OTT (Over-The-Top)', 'DIGITAL' => 'DIGITAL'
    ];

    public const GENRE_SELECT = [
        '1' => 'Action', '2' => 'Anime', '3' => 'Award-Winning', '4' => 'Celebrate Pride', '5' => 'Children & Family',
        '6' => 'Classics', '7' => 'Comedies', '8' => 'Crimes', '9' => 'Documentaries', '10' => 'Dramas', '11' => 'Fantasy',
        '12' => 'Hollywood', '13' => 'Horror', '14' => 'Independent', '15' => 'Music & Musicals', '16' => 'Romance',
        '17' => 'Sci-fi', '18' => 'Sport', '19' => 'Stand-Up Comedy', '20' => 'Thriller',
    ];

    protected $table = 'files';

    protected $dates = [
        'date_received',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'air_date',
    ];

    protected $fillable = [
        'title_of_content',
        'channels' => 'array',
        'segment',
        'episode',
        'file_extension',
        'duration',
        'resolution',
        'file_size',
        'size_type',
        'path',
        'storage',
        'date_received',
        'air_date',
        'year',
        'period',
        'start_date',
        'end_date',
        'types' => 'array',
        'territory',
        'genres' => 'array',
        'me',
        'khmer_dub',
        'poster',
        'trailer_promo',
        'synopsis',
        'remark',
        'file_available',
        'content_id',
        'series_id',
        'fileId',
        'user_id',
    ];

    public function getAirDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setAirDateAttribute($value)
    {
        $this->attributes['air_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getDateReceivedAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateReceivedAttribute($value)
    {
        $this->attributes['date_received'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getStartTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.datetime_format')) : null;
    }

    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = $value ? Carbon::createFromFormat(config('panel.datetime_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function series(){
        return $this->beLongsTo(Series::class, 'series_id');
    }

    public function user(){
        return $this->beLongsTo(User::class, 'user_id');
    }
}
