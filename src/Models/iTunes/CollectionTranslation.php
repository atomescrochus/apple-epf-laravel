<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionTranslation extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'collection_translation';
    protected $primaryKey = "collection_id";
    protected $fillable = ['export_date', 'collection_id', 'language_code', 'is_pronunciation', 'translation', 'translation_type_id'];
}
