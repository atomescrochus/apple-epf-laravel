<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Apple's Enterprise Partner Feed (EPF) credentials
    |--------------------------------------------------------------------------
    |
    | You can get those values in the email you should have received from Apple
    | when joining the performance partner program.
    |
    */

    'user_id'  => env('EPF_USER_ID'),
    'password' => env('EPF_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Database connection
    |--------------------------------------------------------------------------
    |
    | Which database connection to use to import. Defaults to 'apple-epf'.
    |
    */

    'database_connection' => env('EPF_DATABASE_CONNECTION', 'apple-epf'),

    /*
    |--------------------------------------------------------------------------
    | Database import by chunks
    |--------------------------------------------------------------------------
    |
    | Each database has its own limits in terms of maximum size we are able
    | to insert all at once. Since this packages uses transactions for the whole
    | importation. It will commit the transactions multiple times by chunks in
    | order to insert faster and to not hit that limit.
    |
    | If you don't know what you are doing, don't change this.
    |
    */

    'database_importation_chunks' => env('EPF_DATABASE_IMPORT_BY_CHUNKS', 500),

    /*
    |--------------------------------------------------------------------------
    | Named queue
    |--------------------------------------------------------------------------
    |
    | Which queue connection to use to import. Defaults to 'default'.
    |
    */

    'queue' => env('EPF_QUEUE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Chain jobs
    |--------------------------------------------------------------------------
    |
    | Wether to chain the jobs or not. This package uses jobs for each download,
    | extract and import. If this is set to true, the next jobs will dispatch
    | themselves.
    |
    | Ex:
    |   1. DownloadJob for file application.tbz is done, go to next
    |   2. ExtractJob for file application.tbz is done, go to next
    |   3. ImportJob for file application is done
    |
    | By default set to false for full control.
    |
    */

    'chain_jobs' => env('EPF_CHAIN_JOBS', false),

    /*
    |--------------------------------------------------------------------------
    | Artisan commands
    |--------------------------------------------------------------------------
    |
    | Setting it to false will deactivate any artisan command related to EPF. 
    | Useful to not clutter your artisan CLI when you only want to use the models provided
    | by the package.
    |
    */
    
    'include_artisan_cmd' => true,

    /*
    |--------------------------------------------------------------------------
    | Storage folders
    |--------------------------------------------------------------------------
    |
    | Folders used when downloading, extracting and processing EPFs.
    | This package will use the app/local filesystem.
    |
    */

    'storage_folder'    => 'epf-imports',
    'archive_folder'    => 'archives',
    'extraction_folder' => 'files',
    
    /*
    |--------------------------------------------------------------------------
    | Included in the importation and migrations
    |--------------------------------------------------------------------------
    |
    | If you don't need to import everything from Apple's EPF. This configuration
    | helps to only migrate the needed tables and to only import the right models.
    |
    | To exclude a model AND the migration, comment or remove any of the models below.
    |     |
    | Appwapp\EPF\Models\Itunes\KeyValue::class should always be used, as it is used
    | for pruning old data when ingesting a full feed.
    |
    */
    'included_models' => [
        // Itunes
        Appwapp\EPF\Models\Itunes\Application::class,
        Appwapp\EPF\Models\Itunes\ApplicationDetail::class,
        Appwapp\EPF\Models\Itunes\ApplicationDeviceType::class,
        Appwapp\EPF\Models\Itunes\Artist::class,
        Appwapp\EPF\Models\Itunes\ArtistApplication::class,
        Appwapp\EPF\Models\Itunes\ArtistCollection::class,
        Appwapp\EPF\Models\Itunes\ArtistSong::class,
        Appwapp\EPF\Models\Itunes\ArtistTranslation::class,
        Appwapp\EPF\Models\Itunes\ArtistType::class,
        Appwapp\EPF\Models\Itunes\ArtistVideo::class,
        Appwapp\EPF\Models\Itunes\Collection::class,
        Appwapp\EPF\Models\Itunes\CollectionSong::class,
        Appwapp\EPF\Models\Itunes\CollectionTranslation::class,
        Appwapp\EPF\Models\Itunes\CollectionType::class,
        Appwapp\EPF\Models\Itunes\CollectionVideo::class,
        Appwapp\EPF\Models\Itunes\DeviceType::class,
        Appwapp\EPF\Models\Itunes\Genre::class,
        Appwapp\EPF\Models\Itunes\GenreApplication::class,
        Appwapp\EPF\Models\Itunes\GenreArtist::class,
        Appwapp\EPF\Models\Itunes\GenreCollection::class,
        Appwapp\EPF\Models\Itunes\GenreImix::class,
        Appwapp\EPF\Models\Itunes\GenreVideo::class,
        Appwapp\EPF\Models\Itunes\KeyValue::class,
        Appwapp\EPF\Models\Itunes\MediaType::class,
        Appwapp\EPF\Models\Itunes\ParentalAdvisory::class,
        Appwapp\EPF\Models\Itunes\Role::class,
        Appwapp\EPF\Models\Itunes\Song::class,
        Appwapp\EPF\Models\Itunes\SongTranslation::class,
        Appwapp\EPF\Models\Itunes\Storefront::class,
        Appwapp\EPF\Models\Itunes\TranslationType::class,
        Appwapp\EPF\Models\Itunes\Video::class,
        Appwapp\EPF\Models\Itunes\VideoTranslation::class,

        // Match
        Appwapp\EPF\Models\Match\ArtistMatch::class,
        Appwapp\EPF\Models\Match\CollectionMatch::class,
        Appwapp\EPF\Models\Match\SongMatch::class,
        Appwapp\EPF\Models\Match\VideoMatch::class,

        // Popularity
        Appwapp\EPF\Models\Popularity\AlbumPopularityPerGenre::class,
        Appwapp\EPF\Models\Popularity\FreeApplicationPopularityPerGenre::class,
        Appwapp\EPF\Models\Popularity\FreeIpadApplicationPopularityPerGenre::class,
        Appwapp\EPF\Models\Popularity\PaidApplicationPopularityPerGenre::class,
        Appwapp\EPF\Models\Popularity\PaidIpadApplicationPopularityPerGenre::class,
        Appwapp\EPF\Models\Popularity\SongPopularityPerGenre::class,

        // Pricing
        Appwapp\EPF\Models\Pricing\ApplicationPrice::class,
        Appwapp\EPF\Models\Pricing\CollectionPrice::class,
        Appwapp\EPF\Models\Pricing\SongPrice::class,
        Appwapp\EPF\Models\Pricing\VideoPrice::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Filter imported data
    |--------------------------------------------------------------------------
    |
    | The apple EPF feeds are extremely big. Millions of rows are imported with 
    | the full feed. If you use only a fraction of the data, we highly suggest
    | to filter only the data you need in the tables you included.
    |
    | Determine the filtering rules. The package will "pluck" the itunes IDs out 
    | of your own models and use it to filter the data. Cache will also be used 
    | so the collection of IDs are only fetched once per importation.
    |
    | This filter will have no effect if the model is not included in 'included_models'.
    |
    | Model supported:
    | - Appwapp\EPF\Models\Itunes\Artist::class
    |
    */
    'filter_by' => [
        // Appwapp\EPF\Models\Itunes\Artist::class => [App\Models\Palmares\Artist::class, 'itunes_id']
    ]
];
