FROM ubuntu
RUN apt update
RUN apt install -y apache2 php libapache2-mod-php php-mysql
WORKDIR /var/www/html

# Copy index.php to the Apache default document root
COPY . /var/www/html/

EXPOSE 81
# original command apachectl -D FOREGROUND will not wotk use full path of /usr/sbin/apache2ctl
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]