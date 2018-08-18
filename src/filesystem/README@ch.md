
chown -R www.www /data/wwwroot/qingmvc;
find /data/wwwroot/qingmvc -type d -exec chmod 755 {} \;
find /data/wwwroot/qingmvc -type f -exec chmod 644 {} \;

文件夹权限：755
文件权限：644