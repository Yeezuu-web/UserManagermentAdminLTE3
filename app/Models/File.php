<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Day;
use App\Models\User;
use \DateTimeInterface;
use App\Models\Channel;
use App\Models\Segment;
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

    public const TYPE_SELECT = [
        'FTA' => 'FTA (Free-To-Air)', 'OTT' => 'OTT (Over-The-Top)', 'DIGITAL' => 'DIGITAL'
    ];

    public const GENRE_SELECT = [
        '1' => 'Action', '2' => 'Anime', '3' => 'Award-Winning', '4' => 'Celebrate Pride', '5' => 'Children & Family',
        '6' => 'Classics', '7' => 'Comedies', '8' => 'Crimes', '9' => 'Documentaries', '10' => 'Dramas', '11' => 'Fantasy',
        '12' => 'Hollywood', '13' => 'Horror', '14' => 'Independent', '15' => 'Music & Musicals', '16' => 'Romance',
        '17' => 'Sci-fi', '18' => 'Sport', '19' => 'Stand-Up Comedy', '20' => 'Thriller',
    ];

    public const STORAGE_SELECT = [
        'Lacie' => 'Lacie',
        'IBM'   => 'IBM',
        'LTO'   => 'LTO',
        'Tape'  => 'Tape',
        'Other' => 'Other'
    ];

    public const SIZE_TYPE_SELECT = [
        'TB'    => 'TB',
        'GB'    => 'GB',
        'MB'    => 'MB',
        'KB'    => 'KB'
    ];

    public const FILE_EXTENSION_SELECT = [
        'MXF'   => 'MXF',
        'MP4'   => 'MP4',
        'MPEG'  => 'MPEG',
        'AVI'   => 'AVI',
        'OTHER' => 'OTHER'
    ];

    public const RESOLUTION_SELECT = [
        'HD'    => 'HD',
        'SD'    => 'SD',
        'OTHER' => 'OTHER'
    ];

    public const TERRITORY_SELECT = [
        'CAMBODIA'  => 'CAMBODIA',
        'GOBAL'     => 'GLOBAL',
        'OTHER'     => 'OTHER'
    ];

    public const ME_RADIO = [
        '1' => 'Have',
        '2' => 'Don\'t have'
    ];

    public const KHMER_DUB_RADIO = [
        '1' => 'Have',
        '2' => 'Don\'t have'
    ];

    public const POSTER_RADIO = [
        '1' => 'Have',
        '2' => 'Don\'t have'
    ];

    public const TRAILER_PROMO_RADIO = [
        '1' => 'Have',
        '2' => 'Don\'t have'
    ];

    protected $table = 'files';

    protected $dates = [
        'duration',
        'date_received',
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'air_date',
    ];

    protected $casts = [
        'types' => 'array',
        'genres' => 'array'
    ];

    protected $fillable = [
        'title_of_content',
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
        'types',
        'territory',
        'genres',
        'me',
        'khmer_dub',
        'poster',
        'trailer_promo',
        'synopsis',
        'remark',
        'file_available',
        'seg_break',
        'content_id',
        'series_id',
        'fileId',
        'user_id',
    ];

    public function getDurationAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.time_format')) : null;
    }

    // public function setDurationAttribute($value)
    // {
    //     $this->attributes['duration'] = $value ? Carbon::createFromFormat(config('panel.time_format'), $value)->format('H:i:s') : null;
    // }

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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d-m-Y H:i:s');
    }

    public function series()
    {
        return $this->beLongsTo(Series::class, 'series_id');
    }

    public function user()
    {
        return $this->beLongsTo(User::class, 'user_id');
    }
    
    public function segments()
    {
        return $this->belongsToMany(Segment::class, 'file_segment_pivot', 'file_id', 'segment_id')
        ->withPivot(['som', 'eom']);
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class, 'channel_file', 'file_id', 'channel_id')->withTimestamps();
    }

    public function days()
    {
        return $this->beLongsToMany(Day::class)
        ->withTimestamps()
        ->withPivot(['position_order']);
    }

    public static function boot(){
        parent::boot();

        static::creating(function($model) {
            $model->content_id = File::where('series_id', $model->series_id)->max('content_id') + 1;
            $model->fileId = $model->series_id .''. str_pad($model->content_id, 5, '0', STR_PAD_LEFT);
        });
        
        static::updating(function($model) {
            $content_id = File::where('series_id', $model->series_id)->max('content_id') + 1;
            $model->content_id = $content_id;
            $fileId = $model->series_id .''. str_pad($model->content_id, 5, '0', STR_PAD_LEFT);
            $model->fileId = $fileId;
        });
    }
}
