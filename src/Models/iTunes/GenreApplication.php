<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class GenreApplication extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'genre_application';
    protected $primaryKey = "genre_id";
    protected $fillable = ['export_date', 'genre_id', 'application_id', 'is_primary'];
}
