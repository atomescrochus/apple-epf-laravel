<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class SongTranslation extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'song_translation';
    protected $primaryKey = "song_id";
    protected $fillable = ['export_date', 'song_id', 'language_code', 'is_pronunciation', 'translation', 'translation_type_id'];

    protected $casts = [
        'is_pronunciation' => 'boolean',
    ];
}
