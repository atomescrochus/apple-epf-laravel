<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    use ExportDate;

    use Atomescrochus\EPF\Traits\ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'video';
    protected $primaryKey = "video_id";

    protected $casts = [
        //
    ];

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
}
