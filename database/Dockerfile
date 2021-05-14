# docker/database/Dockerfile
FROM mariadb:latest
RUN usermod -u 1000 mysql && groupmod -g 1000 mysql
WORKDIR /var/www
CMD ["mysqld"]
EXPOSE 3306