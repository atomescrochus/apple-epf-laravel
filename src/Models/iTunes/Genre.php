<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'genre';
    protected $primaryKey = "genre_id";
    protected $fillable = ['export_date', 'genre_id', 'parent_id', 'name'];

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
