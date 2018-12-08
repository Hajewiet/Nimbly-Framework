# deny access to certain file extensions, including PHP files
<FilesMatch "\.(tpl|inc|php|htaccess|md)$">
    deny from all
</FilesMatch>

# index.php is the only PHP file which can be accessed from the browser
<Files index.php>
    allow from all
</Files>

# install.php redirects to index.php
<Files install.php>
    allow from all
</Files>

# never show directory listings for URLs which map to a directory.
Options -Indexes

# follow symbolic links in this directory.
Options +FollowSymLinks

# disable MultiViews
Options -MultiViews

# set the one and only default handler
DirectoryIndex index.php

# pass the default character set
AddDefaultCharset utf-8

# set the default language
DefaultLanguage en-US

# set the security pepper hash code (unique per installation)
SetEnv PEPPER [get sticky.pepper]

# compress text, html, javascript, css, xml:
AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/xml
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/x-javascript

# cache control headers
<ifModule mod_headers.c>
    # 480 weeks
    <filesMatch ".(ico|pdf|flv|jpg|jpeg|png|gif|js|css|swf)$">
    Header set Cache-Control "max-age=290304000, public"
    </filesMatch>
</ifModule>

# rewrite: initialize
RewriteEngine on

RewriteBase /[get sticky.rewritebase]

# rewrite: use cache if available for the requested file
RewriteCond %{REQUEST_URI} ^/[get rewritebase-slash](.*)
RewriteCond ext/data/.tmp/cache/%1 -F
RewriteRule ^ ext/data/.tmp/cache/%1 \[L]

# rewrite: use cache if available for the requested uri
RewriteCond %{REQUEST_URI} ^/[get rewritebase-slash](.*)
RewriteCond data/.tmp/cache/%1._cached_.html -F
RewriteRule ^ data/.tmp/cache/%1._cached_.html \[L]

# rewrite: use EXT static if available for the requested file
RewriteCond %{REQUEST_URI} ^/[get rewritebase-slash](.*)
RewriteCond ext/static/%1 -F
RewriteRule ^ ext/static/%1 \[L]


# rewrite: use CORE static if availble for the requested file
RewriteCond %{REQUEST_URI} ^/[get rewritebase-slash](.*)
RewriteCond core/static/%1 -F
RewriteRule ^ core/static/%1 \[L]

# finally, fallback to PHP to handle the request.
php_flag register_globals off
php_flag magic_quotes_gpc off
php_flag magic_quotes_sybase off
php_flag session.auto_start off
php_flag mbstring.encoding_translation off
php_value mbstring.http_input pass
php_value mbstring.http_output pass
php_value zlib.output_compression 16386
php_value session.gc_maxlifetime 14400
php_value session.cookie_lifetime 14400

# rewrite: redirect anything that is not a file to index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php \[L]

#rewrite: redirect any attempt to access a hidden file/dir (starting with a .) to index.php
RewriteRule ^\..*$ index.php \[L]

# rewrite: don't allow a direct request to a cache file (redirect to index.php)
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /\[^\ ]+/.tmp/cache/.*\._cached_\..*($|\ ) \[NC]
RewriteRule ^ index.php \[L]

# rewrite: don't allow a direct request to a static file folder (redirect to index.php)
RewriteCond %{THE_REQUEST} ^[A-Z]{3,9}\ /\[^\ ]+/(ext|core)/static/.*($|\ ) \[NC]
RewriteRule ^ index.php \[L]
