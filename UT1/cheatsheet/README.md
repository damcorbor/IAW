# AWS

## Creación de instancia EC2
1. Accede al **Laboratorio AWS** → **EC2** → **Instancias** → **Lanzar instancia**.
2. Configura:
   - Nombre de la instancia
   - Sistema operativo
   - Tipo de instancia
   - Almacenamiento
3. **Par de claves (Key Pair):**
   - Crear tipo **RSA**, extensión `.pem`.
   - Guardar la clave privada para futuras conexiones.
4. **Grupo de seguridad (Security Group):**
   - Permitir **SSH (puerto 22)** desde `0.0.0.0/0` para pruebas.
5. Lanzar la instancia → se mostrará en **Ejecución**.
   - Desde el panel se puede: detener, iniciar, reiniciar, ver IP pública, etc.

## Conexión a la instancia vía SSH

1. Selecciona la instancia → **Conectar** → **Cliente SSH**.
2. Pasos a seguir:
   - Cambiar permisos de la clave privada:  
     ```bash
     chmod 400 privada.pem
     ```
   - Conectar mediante SSH:  
     ```bash
     ssh -i "privada.pem" admin@<IP-Pública-EC2>
     ```

### Nota sobre claves SSH
- **Clave privada**: archivo `.pem` que descargaste, **no compartir**.
- **Clave pública**: asociada a la instancia en AWS, permite autenticación segura.


---


# Git & GitHub 

## Acceso a GitHub por SSH
1. Genera un par de claves SSH si no lo tienes:  
   ```ssh-keygen -t rsa -b 4096 -C "tu_email@example.com"```
2. Copia el contenido de tu clave pública:  
   ```cat ~/.ssh/id_rsa.pub```
3. En GitHub → **Settings** → **SSH and GPG keys** → **New SSH key**.  
   - Pega el contenido de tu clave pública.  
   - Guarda los cambios.  

## Configuración de Git en tu equipo
1. Instala Git (ejemplo en Ubuntu/Debian):  
   ```sudo apt install git```
2. Configura tu identidad (se guarda de forma global en el sistema):  
   ```bash
      git config --global user.name "Tu Nombre Completo"
      git config --global user.email tu_email@example.com

## Crear un repositorio
Tienes dos opciones:  

- **Desde GitHub**: crea un nuevo repositorio desde la web y sigue las instrucciones que te da.  
- **Desde local**: inicializa un repositorio y luego conéctalo con GitHub:  
  ```bash
     git init
     git remote add origin git@github.com:usuario/repositorio.git
     git branch -M main```
     git push -u origin main

## Clonar un repositorio
1. Sitúate en el directorio donde quieras clonar.  
2. Ejecuta:  
   ```git clone git@github.com:usuario/repositorio.git```

## Trabajar con cambios

### Subir cambios a GitHub (EXPLICAR.......................................................................)
```bash   
   echo "Esto es una prueba" > ejemplo.txt
   git add .
   git commit -m "He creado el fichero ejemplo.txt"
   git push origin main




### Traer cambios desde GitHub
```git pull origin main```

## Comandos útiles
- Ver el estado de los archivos:  
  ```git status```
- Ver historial de commits:  
  ```git log```

