mkdir -p /var/run/mysqld
chown -R mysql /var/run/mysqld
chown -R mysql /var/lib/mysql
chgrp -R mysql /var/lib/mysql
service mysql start
mysql -uroot -proot -e "create database LearnBackend";
php /LearnBackend/artisan migrate
php /LearnBackend/artisan serve --host=0.0.0.0 --port=80

# sudo docker run -p 18000:80 -v ~/LearnBackend/:/LearnBackend/ -d --rm ubuntu:LearnBackend