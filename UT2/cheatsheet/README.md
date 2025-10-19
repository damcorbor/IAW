# CHEATSHEET IAW – NGINX (Prácticas 2.1 a 2.5)

---

## Práctica 2.1 – Instalación y configuración de servidor web Nginx

***Actualizar repositorios e instalar Nginx***
sudo apt update && sudo apt upgrade
sudo apt install nginx

***Comprobar estado del servicio***
systemctl status nginx

***Ruta por defecto del sitio web***
/var/www/html/index.nginx-debian.html

***Ver logs de acceso y errores***
cat /var/log/nginx/access.log
cat /var/log/nginx/error.log

***Editar el archivo HTML para probar***
sudo nano /var/www/html/index.nginx-debian.html

***Abrir puertos en AWS***
HTTP → 80
HTTPS → 443

---

## Práctica 2.2 – Creación de un sitio virtual

***Crear estructura del nuevo sitio***
sudo mkdir -p /var/www/practica2_2/html
sudo chown -R www-data:www-data /var/www/practica2_2/html
sudo chmod -R 755 /var/www/practica2_2/html

***Archivo de configuración***
sudo nano /etc/nginx/sites-available/practica2_2

***Contenido básico***
server {
    listen 80;
    listen [::]:80;
    root /var/www/practica2_2/html;
    index index.html;
    server_name practica2_2;
    location / {
        try_files $uri $uri/ =404;
    }
}

***Activar el sitio***
sudo ln -s /etc/nginx/sites-available/practica2_2 /etc/nginx/sites-enabled/
sudo systemctl restart nginx

***Editar archivo hosts (Linux o Windows)***
ip_publica practica2_2

***Comprobar configuración***
sudo nginx -t

---

## Práctica 2.3 – Autenticación en Nginx

***Instalar herramienta para contraseñas***
sudo apt install apache2-utils

***Crear archivo de usuarios***
sudo htpasswd -c /etc/nginx/.htpasswd profe
sudo htpasswd /etc/nginx/.htpasswd usuario2
cat /etc/nginx/.htpasswd

***Configurar autenticación en el bloque del sitio***
sudo nano /etc/nginx/sites-available/tarea2.conf

***Ejemplo***
location / {
    auth_basic "Área restringida";
    auth_basic_user_file /etc/nginx/.htpasswd;
    try_files $uri $uri/ =404;
}

***Reiniciar Nginx***
sudo systemctl restart nginx

***Ver logs***
cat /var/log/nginx/access.log
cat /var/log/nginx/error.log

***Autenticación solo en una parte (ejemplo contact.html)***
location /contact.html {
    auth_basic "Área restringida";
    auth_basic_user_file /etc/nginx/.htpasswd;
}

***Restringir por IP + usuario***
location / {
    satisfy all;
    allow 192.168.1.1/24;
    deny all;
    auth_basic "Zona segura";
    auth_basic_user_file /etc/nginx/.htpasswd;
}

---

## Práctica 2.4 – Proxy inverso con Nginx

### En el servidor web (webserver)

***Renombrar configuración***
sudo mv /etc/nginx/sites-available/tarea2 /etc/nginx/sites-available/webserver

***Editar archivo***
server {
    listen 8080;
    root /var/www/tarea2/html/simple-static-website;
    server_name webserver;
    index index.html;
    location / {
        try_files $uri $uri/ =404;
    }
}

***Actualizar enlace simbólico***
sudo unlink /etc/nginx/sites-enabled/tarea2
sudo ln -s /etc/nginx/sites-available/webserver /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx

***Abrir puerto 8080 en AWS (HTTP TCP 8080)***

---

### En el servidor proxy inverso (ejemplo-proxy)

***Instalar Nginx***
sudo apt update && sudo apt install nginx

***Crear configuración***
sudo nano /etc/nginx/sites-available/ejemplo-proxy.conf

***Contenido***
server {
    listen 80;
    server_name ejemplo-proxy;
    location / {
        proxy_pass http://webserver:8080;
    }
}

***Activar sitio***
sudo ln -s /etc/nginx/sites-available/ejemplo-proxy /etc/nginx/sites-enabled/
sudo systemctl restart nginx

***Editar /etc/hosts de la máquina local***
ip_proxy ejemplo-proxy

***Añadir cabecera personalizada***
add_header Host proxy_inverso_tunombre;

(También puede añadirse en el servidor web con otro nombre para comprobar ambas cabeceras.)

---

## Práctica 2.5 – Activación HTTPS en proxy inverso Nginx

***Crear directorio para certificados***
sudo mkdir /etc/nginx/ssl

***Generar certificado autofirmado***
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
-keyout /etc/nginx/ssl/server.key -out /etc/nginx/ssl/server.crt

***Editar configuración del proxy (ejemplo-proxy)***
sudo nano /etc/nginx/sites-available/ejemplo-proxy

***Bloque principal con SSL***
server {
    listen 443 ssl;
    server_name ejemplo-proxy;
    ssl_certificate /etc/nginx/ssl/server.crt;
    ssl_certificate_key /etc/nginx/ssl/server.key;
    ssl_ciphers 'TLS_AES_128_GCM_SHA256:TLS_AES_256_GCM_SHA384:ECDHE-RSA-AES128-GCM-SHA256';
    ssl_protocols TLSv1.2 TLSv1.3;
    location / {
        proxy_pass http://webserver:8080;
        add_header Host proxy_inverso_https;
    }
    access_log /var/log/nginx/https_access.log;
}

***Redirección forzosa de HTTP a HTTPS***
server {
    listen 80;
    server_name ejemplo-proxy;
    access_log /var/log/nginx/http_access.log;
    return 301 https://ejemplo-proxy$request_uri;
}

***Reiniciar Nginx***
sudo systemctl restart nginx

***Comprobar logs***
cat /var/log/nginx/http_access.log
cat /var/log/nginx/https_access.log

***Prueba final***
- Acceder a https://ejemplo-proxy → debe funcionar con aviso de certificado autofirmado.
- Acceder a http://ejemplo-proxy → debe redirigir automáticamente a HTTPS.
