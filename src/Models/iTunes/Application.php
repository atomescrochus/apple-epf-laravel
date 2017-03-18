<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'application';
    protected $primaryKey = "application_id";

    protected $casts = [
        //
    ];

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
