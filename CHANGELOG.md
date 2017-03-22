# Changelog

## Next (2017-03-18)
- First draft of models for table, except `video_translation`, see readme's notes for explanation
- Requires to have values in the `.env` file, for usage with `config/apple-epf.php`
- Config flag to include, or not, the artisan commands
- Command to import to database:
    - Can download files for full and increment imports
    - Can verify the md5 checksum of downloaded files
    - Can extract download `tbz` files
    - Seems to be able to import

## 0.0.1 (2017-03-18)
- Base skeleton for the package, based on appstract/php-skeleton