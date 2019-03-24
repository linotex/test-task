FROM mysql:5.6

RUN apt-get update
RUN apt-get install -y nano mc
ENV MYSQL_ROOT_PASSWORD 123

#COPY my.cnf /etc/mysql/my.cnf
#RUN chmod 755 /etc/mysql/my.cnf

COPY init.sql /docker-entrypoint-initdb.d/init.sql
WORKDIR /var/lib/mysql