# CHULETA RESUMEN – Unidad 3: Implantación de Aplicaciones Web en Servidor LAMP

---

## Práctica 3.1 – Instalación de la pila LAMP

### Componentes:
- L → Linux (Debian)  
- A → Apache (Servidor Web)  
- M → MariaDB (Base de datos)  
- P → PHP (Lenguaje dinámico)

### Instalación:
```bash
sudo apt update && sudo apt upgrade
sudo apt install apache2
sudo apt install mariadb-server
sudo apt install php libapache2-mod-php php-mysql
sudo systemctl restart apache2
```

### Comprobaciones:
- Apache funcionando: `http://IP`
- PHP funcionando:
  ```bash
  sudo nano /var/www/html/info.php
  ```
  Contenido:
  ```php
  <?php phpinfo(); ?>
  ```
  Acceder: `http://IP/info.php`

### Crear bases de datos y usuarios:
```sql
sudo mariadb
CREATE DATABASE nombre_db;
CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON nombre_db.* TO 'usuario'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Prueba de conexión PHP ↔ MariaDB:
Archivo `prueba_base_datos.php`:
```php
<?php
$mysqli = new mysqli("localhost", "usuario", "contraseña", "nombre_db");
if ($mysqli->connect_error) die("Error: ".$mysqli->connect_error);
echo "Conexión OK";
?>
```

---

## Práctica 3.2 – Herramientas relacionadas con LAMP

### phpMyAdmin (gestor web de BBDD):
```bash
sudo apt install phpmyadmin
sudo ln -s /usr/share/phpmyadmin /var/www/html/phpmyadmin
sudo systemctl restart apache2
```
Acceso: `http://IP/phpmyadmin`


### GoAccess (análisis de logs Apache):
```bash
sudo apt install goaccess
sudo goaccess /var/log/apache2/access.log \
  --log-format='%h %^[%d:%t %^] "%r" %s %b "%R" "%u"' \
  --date-format='%d/%b/%Y' \
  --time-format='%T' \
  --real-time-html \
  -o /var/www/html/report.html
sudo chmod 644 /var/www/html/report.html
http://IP_DEL_SERVIDOR/report.html
```
Acceso: `http://IP/report.html`

---

## Práctica 3.3 – VirtualHosting con Apache

### Archivos importantes:
- `/etc/apache2/sites-available/`
- `/etc/apache2/sites-enabled/`

### Crear usuario administrador total para bbdd
```bash
sudo mysql;
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'pass123';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
```

### Crear nuevos sitios:
```bash
cd /etc/apache2/sites-available
sudo cp 000-default.conf iescaminas.conf
sudo cp 000-default.conf departamentos.conf
```

Editar cada archivo:
```apache
<VirtualHost *:80>
    ServerName www.iescaminas_local.org
    DocumentRoot /var/www/iescaminas
    ErrorLog ${APACHE_LOG_DIR}/iescaminas_error.log
    CustomLog ${APACHE_LOG_DIR}/iescaminas_access.log combined
</VirtualHost>
```

Activar y reiniciar:
```bash
sudo a2ensite iescaminas.conf
sudo a2ensite departamentos.conf
sudo systemctl reload apache2
```

Modificar `/etc/hosts`:
```
IP  www.iescaminas_local.org
IP  www.departamentosiescaminas.org
```

---

## Práctica 3.4 – Implantación aplicación BookMedik

### Instalación:
```bash
cd /var/www
sudo git clone https://github.com/evilnapsis/bookmedik.git
```

### VirtualHost:
```apache
<VirtualHost *:80>
    ServerName bookmedik.david.org
    DocumentRoot /var/www/bookmedik
    <Directory /var/www/bookmedik>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Base de datos:
```sql
CREATE DATABASE bookmedik;
CREATE USER 'bookmedik_admin'@'localhost' IDENTIFIED BY 'hola01';
GRANT ALL PRIVILEGES ON bookmedik.* TO 'bookmedik_admin'@'localhost';
FLUSH PRIVILEGES;
```

Importar el esquema:
```bash
sudo mariadb bookmedik < /var/www/bookmedik/schema.sql
```

### Configuración de conexión:
Archivo `/var/www/bookmedik/core/controller/Database.php`
```php
$con = new mysqli("localhost","bookmedik_admin","hola01","bookmedik");
```

### Configuración con config.ini:
Archivo `/var/www/bookmedik/config.ini`:
```ini
[database]
host = localhost
name = bookmedik
user = bookmedik_admin
pass = hola01
charset = utf8mb4
```

Código modificado en `Database.php`:
```php
$config = parse_ini_file(__DIR__.'/../../config.ini', true);
$db = $config['database'];
$con = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
$con->set_charset($db['charset']);
```

Permisos:
```bash
sudo chown www-data:www-data /var/www/bookmedik/config.ini
sudo chmod 640 /var/www/bookmedik/config.ini
```

---

## Práctica 3.5 – Instalación del CMS WordPress

### Descargar y descomprimir:
```bash
cd /var/www
sudo wget https://wordpress.org/latest.tar.gz
sudo tar -xzvf latest.tar.gz
```

### Crear base de datos:
```sql
CREATE DATABASE wordpress;
CREATE USER 'wordpress_admin'@'localhost' IDENTIFIED BY 'hola01';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress_admin'@'localhost';
FLUSH PRIVILEGES;
```

### VirtualHost:
```apache
<VirtualHost *:80>
    ServerName wordpress.david.org
    DocumentRoot /var/www/wordpress
    <Directory /var/www/wordpress>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Activar:
```bash
sudo a2ensite wordpress.conf
sudo systemctl reload apache2
```

### Configurar base de datos en WordPress:
```bash
sudo cp /var/www/wordpress/wp-config-sample.php /var/www/wordpress/wp-config.php
sudo nano /var/www/wordpress/wp-config.php
```

Editar:
```php
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress_admin' );
define( 'DB_PASSWORD', 'hola01' );
define( 'DB_HOST', 'localhost' );
```

### Instalación desde navegador:
URL: `http://wordpress.david.org`

Datos usados:
- Site title: damcorbor  
- Usuario: admin  
- Contraseña: 7,XiP-?m-z$5LLV  
- Email: daxenko85@gmail.com  

Acceso posterior: `http://wordpress.david.org/wp-admin`

---

## Comandos y rutas clave

| Función | Comando / Ruta |
|----------|----------------|
| Reiniciar Apache | `sudo systemctl reload apache2` |
| Archivos de configuración Apache | `/etc/apache2/sites-available/` |
| Directorio web | `/var/www/` o `/var/www/html/` |
| Logs de Apache | `/var/log/apache2/` |
| Base de datos | `sudo mariadb` |
| Ver usuarios MariaDB | `SELECT user, host FROM mysql.user;` |
| Ver permisos | `SHOW GRANTS FOR 'usuario'@'localhost';` |
| Archivo info PHP | `/var/www/html/info.php` |
| Editar hosts | `/etc/hosts` |
| phpMyAdmin | `http://IP/phpmyadmin` |
| Permisos ficheros | Archivos 644 / Directorios 755 |

---

## Resumen rápido para el examen

**Apache**
- Activar sitio: `sudo a2ensite nombre.conf`
- Desactivar sitio: `sudo a2dissite nombre.conf`

**Logs**
- Errores: `/var/log/apache2/error.log`
- Accesos: `/var/log/apache2/access.log`

**PHP**
- Reiniciar para aplicar cambios:  
  `sudo systemctl restart apache2`

**MariaDB**
- Ver usuarios:  
  `SELECT user, host FROM mysql.user;`
- Ver permisos:  
  `SHOW GRANTS FOR 'usuario'@'localhost';`

**Permisos web**
- Archivos PHP: 644  
- Directorios: 755  
- Propietario: `www-data:www-data`
