<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ApplicationPopularityPerGenre extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'application_popularity_per_genre';
    protected $primaryKey = "storefront_id";
    protected $fillable = ['export_date', 'storefront_id', 'genre_id', 'application_id', 'application_rank'];
}
