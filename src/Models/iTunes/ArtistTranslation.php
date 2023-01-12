<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ArtistTranslation extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'artist_translation';
    protected $primaryKey = "artist_id";
    protected $fillable = ['export_date', 'artist_id', 'language_code', 'is_pronunciation', 'translation', 'translation_type_id'];

    protected $casts = [
        'is_pronunciation' => 'boolean',
    ];
}
