<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class GenreCollection extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'genre_collection';
    protected $primaryKey = "genre_id";
    protected $fillable = ['export_date', 'genre_id', 'collection_id', 'is_primary_collection'];
}
