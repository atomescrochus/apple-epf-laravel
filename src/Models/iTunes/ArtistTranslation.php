<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ArtistTranslation extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'artist_translation';
    protected $primaryKey = "artist_id";

    protected $casts = [
        'is_pronunciation' => 'boolean',
    ];
}