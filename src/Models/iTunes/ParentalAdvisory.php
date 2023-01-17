<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ParentalAdvisory extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parental_advisory';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "parental_advisory_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'parental_advisory_id',
        'name'
    ];

    /**
     * The ParentalAdvisory's songs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class);
    }
}
