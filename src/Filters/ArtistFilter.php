<?php

namespace Appwapp\EPF\Filters;

use Appwapp\EPF\Models\Itunes\ArtistCollection;
use Appwapp\EPF\Models\Itunes\ArtistSong;
use Appwapp\EPF\Models\Itunes\Collection;
use Appwapp\EPF\Models\Itunes\CollectionSong;
use Appwapp\EPF\Models\Itunes\Song;
use Illuminate\Support\Facades\DB;

class ArtistFilter extends Filter
{
    /**
     * The mapping of the models and their database statements.
     *
     * @var array
     */
    public static array $mapping = [
        ArtistCollection::class => 'runArtistCollectionInsert',
        ArtistSong::class       => 'runArtistSongInsert',
        Collection::class       => 'runCollectionInsert',
        CollectionSong::class   => 'runCollectionSongInsert',
        Song::class             => 'runSongInsert',
    ];

    /**
     * Create a new filter instance for artist_collection.
     * 
     * @param  array  $primaryKeys  The primary keys of the model.
     * @param  array  $data         The attributes data of the model.
     *
     * @return void
     */
    public static function runArtistCollectionInsert(array $primaryKeys, array $data): void
    {
        // Use insert statement instead of updateOrCreate
        DB::connection(config('apple-epf.database_connection'))
            ->statement('INSERT INTO artist_collection (export_date, artist_id, collection_id, is_primary_artist, role_id)
                SELECT :export_date, artist_id, :collection_id, :is_primary_artist, :role_id FROM artist WHERE artist_id = :artist_id
                ON DUPLICATE KEY UPDATE artist_collection.export_date = artist_collection.export_date;', 
                array_merge($primaryKeys, $data)
            );
    }
    

    /**
     * Create a new filter instance for artist_song.
     *
     * @param  array  $primaryKeys  The primary keys of the model.
     * @param  array  $data         The attributes data of the model.
     *
     * @return void
     */
    public static function runArtistSongInsert(array $primaryKeys, array $data): void
    {
        // Use insert statement instead of updateOrCreate
        DB::connection(config('apple-epf.database_connection'))
            ->statement('INSERT INTO artist_song (export_date, artist_id, song_id)
                SELECT :export_date, artist_id, :song_id FROM artist WHERE artist_id = :artist_id
                ON DUPLICATE KEY UPDATE artist_song.export_date = artist_song.export_date;', 
                array_merge($primaryKeys, $data)
            );
    }

    /**
     * Create a new filter instance for collection.
     *
     * @param  array  $primaryKeys  The primary keys of the model.
     * @param  array  $data         The attributes data of the model.
     *
     * @return void
     */
    public static function runCollectionInsert(array $primaryKeys, array $data): void
    {
        // Use insert statement instead of updateOrCreate
        DB::connection(config('apple-epf.database_connection'))
            ->statement('INSERT INTO collection (export_date, collection_id, name, title_version, search_terms, parental_advisory_id, artist_display_name, view_url, artwork_url, original_release_date, itunes_release_date, label_studio, content_provider_name, copyright, p_line, media_type_id, is_compilation, collection_type_id)
                SELECT :export_date, collection_id, :name, :title_version, :search_terms, :parental_advisory_id, :artist_display_name, :view_url, :artwork_url, :original_release_date, :itunes_release_date, :label_studio, :content_provider_name, :copyright, :p_line, :media_type_id, :is_compilation, :collection_type_id FROM artist_collection WHERE collection_id = :collection_id
                ON DUPLICATE KEY UPDATE collection.export_date = collection.export_date;', 
                array_merge($primaryKeys, $data)
            );
    }

    /**
     * Create a new filter instance for song.
     *
     * @param  array  $primaryKeys  The primary keys of the model.
     * @param  array  $data         The attributes data of the model.
     *
     * @return void
     */
    public static function runSongInsert(array $primaryKeys, array $data): void
    {
        // Use insert statement instead of updateOrCreate
        DB::connection(config('apple-epf.database_connection'))
            ->statement('INSERT INTO song (export_date, song_id, name, title_version, search_terms, parental_advisory_id, artist_display_name, collection_display_name, view_url, original_release_date, itunes_release_date, track_length, copyright, p_line, preview_url, preview_length)
                SELECT :export_date, song_id, :name, :title_version, :search_terms, :parental_advisory_id, :artist_display_name, :collection_display_name, :view_url, :original_release_date, :itunes_release_date, :track_length, :copyright, :p_line, :preview_url, :preview_length FROM artist_song WHERE song_id = :song_id
                ON DUPLICATE KEY UPDATE song.export_date = song.export_date;', 
                array_merge($primaryKeys, $data)
            );
    }

    /**
     * Create a new filter instance for collection_song.
     *
     * @param  array  $primaryKeys  The primary keys of the model.
     * @param  array  $data         The attributes data of the model.
     *
     * @return void
     */
    public static function runCollectionSongInsert(array $primaryKeys, array $data): void
    {
        // Use insert statement instead of updateOrCreate
        DB::connection(config('apple-epf.database_connection'))
            ->statement('INSERT INTO collection_song (export_date, collection_id, song_id, track_number, volume_number, preorder_only)
                SELECT :export_date, collection_id, :song_id, :track_number, :volume_number, :preorder_only FROM collection WHERE collection_id = :collection_id
                ON DUPLICATE KEY UPDATE collection_song.export_date = collection_song.export_date;', 
                array_merge($primaryKeys, $data)
            );
    }
}
