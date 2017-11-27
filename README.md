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

    <Location ~ "^(?!\/Static$).*$">
        AllowOverride None
        AllowOverrideList None

        Options +FollowSymLinks
        Require local

        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ /index.php?q=$1 [L,QSA]
    </Location>

    <Location "/Static">
        AllowOverride None
        AllowOverrideList None

        Options +FollowSymLinks +MultiViews
        Require local
    </Location>
</VirtualHost>
```
