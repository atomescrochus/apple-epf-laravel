<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'song';
    protected $primaryKey = "song_id";

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
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Artist::class, 'artist_song', 'song_id', 'artist_id');
    }

    public function collections()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Collection::class, 'collection_song', 'song_id', 'collection_id');
    }

    public function mixes()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Mix::class, 'song_mix', 'song_id', 'mix_id');
    }

    public function parentalAdvisory()
    {
        return $this->belongsTo(ParentalAdvisory::class, 'parental_advisory_id');
    }

    public function translations()
    {
        return $this->hasMany(SongTranslation::class, 'song_id');
    }
}
