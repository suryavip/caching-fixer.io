# caching-fixer.io
Caching [fixer.io](http://fixer.io?fpr=suryavip) free account with PHP and cron job.

## Background:
Free account is limited to 1000 requests per month, hourly data and only EUR as base currency. In my case, I'm fine with hourly and base currency limitation, but probably not ok with the monthly requests limit. To avoid exceeding that, rather than my front-end app requesting directly to [fixer.io](http://fixer.io?fpr=suryavip), it's better for me to set an hourly cron job to do the request to [fixer.io](http://fixer.io?fpr=suryavip) and store it on my own server.

24 hours * 31 days is 744 requests. Well below the monthly limit.

## Usage:
1. Create [fixer.io](http://fixer.io?fpr=suryavip) account
1. Put API key to file named `apikey` on `private` directory.
1. Set cron job to run `private/create_cache.php` every hour.
1. `GET cache.json` to read the cache.

## Notes:
1. Make sure to prevent public access to `private` folder (to protect the `apikey` and prevent public from making request to [fixer.io](http://fixer.io?fpr=suryavip) by calling `create_cache.php`). You can use something like `.htaccess`:
	>`Deny from all`
1. `private/apikey` is already on `.gitignore` to prevent leaking that via repo.

