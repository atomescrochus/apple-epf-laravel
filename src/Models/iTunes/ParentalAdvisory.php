<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ParentalAdvisory extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'parental_advisory';
    protected $primaryKey = "parental_advisory_id";
    protected $fillable = ['export_date', 'parental_advisory_id', 'name'];

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
