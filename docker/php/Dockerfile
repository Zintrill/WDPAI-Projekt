# Wybierz odpowiedni obraz bazowy
FROM php:7.4.3-fpm-alpine3.11

# Instaluj wymagane zależności
RUN apk add --no-cache dcron

# Skopiuj plik crontab do kontenera
COPY crontab /etc/crontabs/root

# Uruchom komendę crona w tle
CMD ["crond", "-f"]
