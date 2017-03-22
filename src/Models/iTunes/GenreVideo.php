<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class GenreVideo extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'genre_video';
    protected $primaryKey = "genre_id";
    protected $fillable = ['export_date', 'genre_id', 'video_id', 'is_primary_genre'];
}
