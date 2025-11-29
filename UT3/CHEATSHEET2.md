# CHULETA DEFINITIVA – UNIDAD 3 (LAMP)

## Práctica 3.1 – Instalación de la pila LAMP

Componentes:
- L → Linux (Debian)
- A → Apache
- M → MariaDB
- P → PHP

Instalación:
​```
sudo apt update && sudo apt upgrade
sudo apt install apache2
sudo apt install mariadb-server
sudo apt install php libapache2-mod-php php-mysql
sudo systemctl restart apache2
​```

Comprobación PHP:
Crear:
​```
sudo nano /var/www/html/info.php
​```

Contenido:
​```
<?php phpinfo(); ?>
​```

Acceso navegador:  
`http://IP/info.php`

---

## Crear base de datos y usuario

​```
sudo mariadb
CREATE DATABASE damiandb;
CREATE USER 'damian'@'localhost' IDENTIFIED BY 'clave123';
GRANT ALL PRIVILEGES ON damiandb.* TO 'damian'@'localhost';
FLUSH PRIVILEGES;
EXIT;
​```

Prueba PHP:
Crear `/var/www/html/testdb.php`:
​```
<?php
$mysqli = new mysqli("localhost","damian","clave123","damiandb");
if ($mysqli->connect_error) die("ERROR");
echo "OK conexión";
?>
​```

------------------------------------------------------------

# Práctica 3.2 – phpMyAdmin, Adminer, GoAccess

### phpMyAdmin:
​```
sudo apt install phpmyadmin
sudo ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin
sudo systemctl restart apache2
​```

Acceso:  
`http://IP/phpmyadmin`

### Adminer:
​```
sudo wget https://github.com/vrana/adminer/releases/download/v4.8.1/adminer.php -O /var/www/html/adminer.php
​```

Acceso:  
`http://IP/adminer.php`

### GoAccess:
​```
sudo apt install goaccess
sudo goaccess /var/log/apache2/access.log -o /var/www/html/report.html --real-time-html
​```

Acceso:  
`http://IP/report.html`

------------------------------------------------------------

# Práctica 3.3 – VirtualHosting Apache

Crear confs:
​```
cd /etc/apache2/sites-available
sudo cp 000-default.conf iescaminas.conf
sudo cp 000-default.conf departamentos.conf
​```

Ejemplo iescaminas.conf:
​```
<VirtualHost *:80>
    ServerName www.iescaminas_local.org
    DocumentRoot /var/www/iescaminas
    ErrorLog ${APACHE_LOG_DIR}/ies_error.log
    CustomLog ${APACHE_LOG_DIR}/ies_access.log combined
</VirtualHost>
​```

Activar:
​```
sudo a2ensite iescaminas.conf
sudo a2ensite departamentos.conf
sudo systemctl reload apache2
​```

Hosts cliente:
​```
IP   www.iescaminas_local.org
IP   www.departamentosiescaminas.org
​```

------------------------------------------------------------

# Práctica 3.4 – BookMedik PHP

Clonar:
​```
cd /var/www
sudo git clone https://github.com/evilnapsis/bookmedik.git
sudo chown -R www-data:www-data /var/www/bookmedik
​```

VirtualHost:
​```
<VirtualHost *:80>
    ServerName bookmedik.damcorbor.org
    DocumentRoot /var/www/bookmedik
    <Directory /var/www/bookmedik>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
​```

BD:
​```
CREATE DATABASE bookmedik;
CREATE USER 'bmuser'@'localhost' IDENTIFIED BY 'clave123';
GRANT ALL PRIVILEGES ON bookmedik.* TO 'bmuser'@'localhost';
​```

Importar:
​```
sudo mariadb bookmedik < /var/www/bookmedik/schema.sql
​```

Config:
Editar `core/controller/Database.php`:
​```
$con = new mysqli("localhost","bmuser","clave123","bookmedik");
​```

Cambiar memory_limit (si fuera necesario):
Editar:
/etc/php/8.2/apache2/php.ini
​```
memory_limit = 256M
​```
Reiniciar:
​```
sudo systemctl restart apache2
​```

------------------------------------------------------------

# Práctica 3.5 – WordPress

Descargar:
​```
cd /var/www
sudo wget https://wordpress.org/latest.tar.gz
sudo tar -xzvf latest.tar.gz
sudo chown -R www-data:www-data /var/www/wordpress
​```

BD:
​```
CREATE DATABASE wordpress;
CREATE USER 'wpuser'@'localhost' IDENTIFIED BY 'clave123';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wpuser'@'localhost';
​```

VirtualHost:
​```
<VirtualHost *:80>
    ServerName wordpress.damcorbor.org
    DocumentRoot /var/www/wordpress
    <Directory /var/www/wordpress>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
​```

Activar:
​```
sudo a2ensite wordpress.conf
sudo systemctl reload apache2
​```

Config:
​```
sudo cp /var/www/wordpress/wp-config-sample.php /var/www/wordpress/wp-config.php
sudo nano /var/www/wordpress/wp-config.php
​```

Cambiar:
​```
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wpuser' );
define( 'DB_PASSWORD', 'clave123' );
define( 'DB_HOST', 'localhost' );
​```

Acceso navegador:  
`http://wordpress.damcorbor.org`

------------------------------------------------------------

# Comandos clave examen (LAMP)

Apache:
- Reiniciar → `sudo systemctl restart apache2`
- Activar sitio → `sudo a2ensite nombre.conf`
- Desactivar sitio → `sudo a2dissite nombre.conf`

MariaDB:
​```
sudo mariadb
SELECT user, host FROM mysql.user;
SHOW GRANTS FOR 'user'@'localhost';
​```

Permisos web:
- Archivos: 644
- Directorios: 755
- Propietario: www-data:www-data

Logs:
- `/var/log/apache2/error.log`
- `/var/log/apache2/access.log`
