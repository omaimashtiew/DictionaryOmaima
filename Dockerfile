FROM ubuntu
RUN apt update

RUN apt install -y apache2 php libapache2-mod-php php-mysql
RUN a2enmod rewrite
RUN service apache2 restart
WORKDIR /var/www/html

# Copy index.php to the Apache default document root
COPY . /var/www/html/

EXPOSE 80
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]
