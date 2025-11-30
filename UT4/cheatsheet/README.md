```bash
Types: deb

URIs: https://download.docker.com/linux/debian

Suites: trixie

Components: stable

Signed-By: /etc/apt/keyrings/docker.asc
```
```bash
sudo usermod -aG docker damcorbor
```
reiniicar





CHEATSHEET
```bash
docker run -it ubuntu bash          ← entrar a contenedor
docker run -d --name=algo imagen    ← background
docker exec -it cont bash           ← entrar mientras está en ejecución
docker exec -d cont comando         ← ejecutar sin entrar
docker cp host cont:ruta            ← copiar hacia contenedor
docker cp cont:ruta host            ← copiar hacia host
docker attach cont                  ← enganchar stdout
docker logs -f cont                 ← ver logs
docker ps -a                        ← ver contenedores
docker rm / docker rmi              ← borrar
docker run -p 8080:80 nginx         ← exponer puertos
```






Ejercicio 2.1 – Imagen personalizada (Ubuntu)

Enunciado:
Crea un Dockerfile que:

Use ubuntu:22.04 como base

Instale Apache, PHP y el módulo php para Apache

Limpie apt para reducir tamaño

Cree un archivo /var/www/html/info.php con <?php phpinfo(); ?>

Use /usr/sbin/apache2ctl -D FOREGROUND como comando final

No hace falta ejecutarlo, solo escribir el Dockerfile.

Dockerfile (SOLUCIÓN)

Cópialo tal cual para que funcione.
```bash
FROM ubuntu:22.04

RUN apt update && \
    apt install -y apache2 php libapache2-mod-php && \
    apt clean && rm -rf /var/lib/apt/lists/*

RUN echo "<?php phpinfo(); ?>" > /var/www/html/info.php

EXPOSE 80

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
```
Ejercicio 2.2 – Lanzar un contenedor con volumen persistente

Enunciado:
Crea un contenedor llamado server1 con la imagen que has creado antes.
Debe:

exponer 8080 → 80

usar un volumen persistente en el host en /opt/webdata

montarlo en /var/www/html dentro del contenedor

ejecutarse en modo -d

tener restart policy "always"

Escribe el comando completo.

Comando Docker run (SOLUCIÓN)
```bash
docker run -d \
  --name server1 \
  -p 8080:80 \
  -v /opt/webdata:/var/www/html \
  --restart=always \
  miimagen:latest
```

(Sustituye miimagen:latest por el nombre/tag de la imagen que generaste con tu Dockerfile.)
