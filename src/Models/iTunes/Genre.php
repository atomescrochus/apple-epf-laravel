<?php

namespace Appwapp\EPF\Models\Itunes;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genre';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'genre_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'genre_id',
        'parent_id',
        'name'
    ];

    /**
     * Gets the Genre's songs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class);
    }
}
