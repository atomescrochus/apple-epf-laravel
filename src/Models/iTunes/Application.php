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
}
