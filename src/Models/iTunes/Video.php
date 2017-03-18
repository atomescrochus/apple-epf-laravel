<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'video';
    protected $primaryKey = "video_id";

    // accessors

    public function getItunesReleaseDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date);
    }

    public function getOriginalReleaseDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date);
    }

    // relationships

    public function artists()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Artist::class, 'artist_video', 'video_id', 'artist_id');
    }

    public function collections()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Collection::class, 'collection_video', 'video_id', 'collection_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_video', 'video_id', 'genre_id');
    }

    public function parentalAdvisory()
    {
        return $this->belongsTo(ParentalAdvisory::class, 'parental_advisory_id');
    }

    public function type()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\MediaType::class, 'media_type_id', 'media_type_id');
    }
}
