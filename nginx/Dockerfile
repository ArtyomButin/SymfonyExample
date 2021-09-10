# docker/nginx/Dockerfile
FROM nginx:1.13

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
WORKDIR /var/www
CMD ["nginx"]
EXPOSE 80
