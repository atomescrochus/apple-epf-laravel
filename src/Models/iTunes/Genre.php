<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'genre';
    protected $primaryKey = "genre_id";

    protected $casts = [
        //
    ];

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'genre_application', 'genre_id', 'application_id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'genre_collection', 'genre_id', 'collection_id');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'genre_video', 'genre_id', 'video_id');
    }
}
