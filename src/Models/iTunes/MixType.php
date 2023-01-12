<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class MixType extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'mix_type';
    protected $primaryKey = "mix_type_id";
    protected $fillable = ['export_date', 'mix_type_id', 'name'];
}
