mkdir -p /var/run/mysqld
chown -R mysql /var/run/mysqld
chown -R mysql /var/lib/mysql
chgrp -R mysql /var/lib/mysql
service apache2 start
service mysql start
php /LearnBackend/artisan serve --host=0.0.0.0

# sudo bash -c 'docker run -p 18000:8000 -v ~/LearnBackend/:/LearnBackend/ -d ubuntu:LearnBackend'
