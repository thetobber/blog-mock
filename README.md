## Apache

#### Core documentation
https://httpd.apache.org/docs/2.4/mod/core.html

#### Access control
http://httpd.apache.org/docs/current/howto/access.html

#### Configuration
```
<VirtualHost *:80>
    ServerAdmin Tobias
    ServerName blogmock.local
    ServerAlias www.blogmock.local
    DocumentRoot "C:/Projects/BlogMock"
    Options None

    Header unset Server
    Header unset X-Powered-By

    Header always set Content-Security-Policy "default-src 'self'; frame-src 'none'"
    Header always set X-Frame-Options "deny"

    Header unset Cache-Control
    Header unset Pragma
    Header unset Expires

    Header always set Cache-Control "no-cache, no-store, must-revalidate"
    Header always set Pragma "no-cache"
    Header always set Expires "-1"

    <Location ~ "^(?!\/Static$).*$">
        AllowOverride None
        AllowOverrideList None

        Options +FollowSymLinks
        Require local

        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^.*$ /Index.php [L,QSA]
    </Location>

    <Location "/Static">
        AllowOverride None
        AllowOverrideList None

        Options +FollowSymLinks +MultiViews
        Require local
    </Location>
</VirtualHost>
```
