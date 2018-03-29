FROM ubuntu:16.04

RUN sed -i 's#http://archive.ubuntu.com#http://mirrors.163.com#g' /etc/apt/sources.list && \
	apt-get update && \
	apt-get install -y software-properties-common && \
	add-apt-repository ppa:alex-p/tesseract-ocr && \
	apt-get update && \
	echo 'mysql-server mysql-server/root_password password root' | debconf-set-selections && \
	echo 'mysql-server mysql-server/root_password_again password root' | debconf-set-selections && \
	apt-get install -y apache2 mysql-server php libapache2-mod-php php-mysql composer zip unzip php-zip php-mbstring php-xml php-curl tesseract-ocr

COPY docker-entrypoint.sh /

ENTRYPOINT /docker-entrypoint.sh
