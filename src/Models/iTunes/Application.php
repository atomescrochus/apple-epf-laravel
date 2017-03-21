<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'application';
    protected $primaryKey = "application_id";
    protected $fillable = ['export_date', 'application_id', 'title', 'recommended_age', 'artist_name', 'seller_name', 'company_url', 'support_url', 'view_url', 'artwork_url_large', 'artwork_url_small', 'itunes_release_date', 'copyright', 'description', 'version', 'itunes_version', 'download_size'];

    // accessors

    public function getItunesReleaseDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date);
    }

    // relationships

    public function artist()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Artist::class, 'artist_application', 'application_id', 'artist_id');
    }

    public function detail()
    {
        return $this->hasOne(ApplicationDetail::class, 'application_id');
    }

    public function devices()
    {
        return $this->belongsToMany(DeviceType::class, 'application_device_type', 'application_id', 'device_type_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_application', 'application_id', 'genre_id');
    }
}
