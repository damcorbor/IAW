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
  
# GIT Y GITHUB

