<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class VideoTranslation extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'video_translation';
    protected $primaryKey = "video_id";
    protected $fillable = ['export_date', 'video_id', 'language_code', 'is_pronunciation', 'translation', 'translation_type_id'];

    protected $casts = [
        'is_pronunciation' => 'boolean',
    ];
}
