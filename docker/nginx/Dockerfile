FROM nginx:latest

RUN apt-get update
RUN apt-get install -y nano mc

WORKDIR /etc/nginx/conf.d

RUN rm /etc/nginx/conf.d/default.conf

COPY school.conf /etc/nginx/conf.d/school.conf
RUN mkdir -p /var/www/public
RUN touch /var/www/public/index.php