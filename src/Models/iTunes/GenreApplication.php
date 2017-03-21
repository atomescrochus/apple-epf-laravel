<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class GenreApplication extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'genre_application';
    protected $primaryKey = "genre_id";
    protected $fillable = ['export_date', 'genre_id', 'application_id', 'is_primary'];

    // relationships
    
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
