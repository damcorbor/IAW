# TEMA 4 – DOCKER (INSTALACIÓN EN LINUX) – RESUMEN EN MARKDOWN
## 1. Qué es Docker CE

Docker CE → Community Edition, versión gratuita.

Componentes:

Docker Engine (daemon)

Docker CLI (cliente)

## 2. Preparar el sistema
sudo apt-get update && sudo apt-get upgrade

## 3. Instalación recomendada de Docker CE
### Paso 1 → Eliminar versiones antiguas
for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do 
    sudo apt-get remove $pkg; 
done

### Paso 2 → Instalar dependencias
sudo apt-get update
sudo apt-get install ca-certificates curl

### Paso 3 → Añadir clave GPG de Docker
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

### Paso 4 → Añadir repositorio Docker CE
echo \
"deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] \
https://download.docker.com/linux/ubuntu \
$(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
sudo tee /etc/apt/sources.list.d/docker.list > /dev/null


Actualizar índice:

sudo apt-get update

### Paso 5 → Instalar Docker
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

## 4. Comprobación de instalación
Versión:
sudo docker version

Contenedor de prueba:
sudo docker run hello-world

## 5. Post-instalación
### Usar Docker sin sudo

Crear grupo docker:

sudo groupadd docker


Añadir tu usuario:

sudo usermod -aG docker $USER


Cerrar sesión y entrar otra vez.

### Si aparecen errores de permisos:
sudo rm -rf ~/.docker/


o

sudo chown "$USER":"$USER" /home/"$USER"/.docker -R
sudo chmod g+rwx "$HOME"/.docker -R

## 6. Gestionar el servicio Docker
Activar arranque automático:
sudo systemctl enable docker.service
sudo systemctl enable containerd.service

Desactivar arranque:
sudo systemctl disable docker.service
sudo systemctl disable containerd.service

Iniciar/Detener/Reiniciar:
sudo systemctl start docker
sudo systemctl stop docker
sudo systemctl restart docker

## 7. Desinstalar Docker completamente
Eliminar paquetes:
sudo apt-get purge docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin docker-ce-rootless-extras

Eliminar datos (⚠️ imágenes y contenedores):
sudo rm -rf /var/lib/docker
sudo rm -rf /var/lib/containerd
sudo rm /etc/apt/sources.list.d/docker.list
sudo rm /etc/apt/keyrings/docker.asc

## 8. Nota rápida Windows/Mac

Se usa Docker Desktop.

Internamente ejecuta una VM Linux.

Mejor usar Linux nativo siempre.

## 9. Playground Docker (sin instalar)

👉 https://labs.play-with-docker.com/

## 10. Resumen ultra rápido para examen
sudo apt update
sudo apt install ca-certificates curl
# añadir GPG + repo
sudo apt install docker-ce docker-ce-cli containerd.io
docker run hello-world
sudo usermod -aG docker $USER
