<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Mix extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'mix';
    protected $primaryKey = "mix_id";
    protected $fillable = ['export_date', 'mix_id', 'mix_collection_id', 'name', 'description', 'rank', 'view_url'];

    // relationships

    public function collections()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\MixCollection::class, 'mix_collection_id');
    }

    public function songs()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Song::class, 'song_mix', 'mix_id', 'song_id');
    }

    public function type()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\MixType::class, 'mix_type_id', 'mix_type_id');
    }
}
