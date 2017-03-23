<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class TranslationType extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'translation_type';
    protected $primaryKey = "translation_type_id";
    protected $fillable = ['export_date', 'translation_type_id', 'name'];
}
