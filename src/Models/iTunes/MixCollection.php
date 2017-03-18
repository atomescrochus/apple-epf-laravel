<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class MixCollection extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'mix_collection';
    protected $primaryKey = "mix_collection_id";

    // accessors

    public function getItunesReleaseDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date);
    }

    // relationships

    public function mixes()
    {
        $this->hasMany(\Atomescrochus\EPF\Models\Mix::class, 'mix_collection_id');
    }

    public function parentalAdvisory()
    {
        return $this->belongsTo(ParentalAdvisory::class, 'parental_advisory_id');
    }

    public function storefront()
    {
        return $this->belongsTo(Storefront::class, 'storefront_id');
    }

    public function type()
    {
        return $this->belongsTo(MixType::class, 'mix_type_id');
    }
}
