<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class SongMix extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'song_mix';
    protected $primaryKey = "song_id";
    protected $fillable = ['export_date', 'song_id', 'mix_id'];
}
