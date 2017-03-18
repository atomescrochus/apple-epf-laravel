<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionTranslation extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'collection_translation';
    protected $primaryKey = "collection_id";
}
