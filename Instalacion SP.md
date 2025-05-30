# 📦 Guía de instalación – Proyecto *Sabores Peruanos* (con Docker desde cero)

Esta guía te enseñará a instalar y ejecutar el proyecto web **Sabores Peruanos** desde tu computadora, aunque **nunca hayas usado Docker antes**.

---

## ✅ Requisitos previos

Antes de comenzar, necesitas instalar dos herramientas gratuitas:

### 1. **Git**
Sirve para descargar (clonar) el proyecto desde GitHub.

- Descargar: https://git-scm.com/downloads
- Durante la instalación, puedes dejar todas las opciones por defecto.

### 2. **Docker Desktop**
Docker es la plataforma que usaremos para crear los contenedores del sitio web y la base de datos.

- Descargar: https://www.docker.com/products/docker-desktop/
- Una vez instalado, **abre Docker Desktop** para que se quede ejecutando en segundo plano.
- En Windows, asegúrate de **activar WSL2** si es necesario (el instalador te guiará).

---

## 🧰 Instalación paso a paso

### 1. Clona el repositorio del proyecto

Abre la terminal (o Git Bash en Windows) y escribe:

```bash
git clone https://github.com/mrubiofiestas/SaboresPeruanos.git
cd SaboresPeruanos
```

---

### 2. Inicia el proyecto con Docker

Desde la carpeta del proyecto (donde está el archivo `docker-compose.yml`), ejecuta:

```bash
docker-compose up -d
```

Docker descargará las imágenes necesarias (PHP + Apache + MySQL), creará los contenedores, y levantará la aplicación.

Esto puede tomar unos minutos la primera vez.

---

## 🌐 Acceso a la aplicación

Cuando el proceso termine, abre tu navegador:

- **Sitio web**: http://localhost
- **phpMyAdmin (para ver la base de datos)**: http://localhost:8080  
  - Usuario: `root`  
  - Contraseña: `clave`


---

## 🧪 Probar el sistema

Puedes ejecutar pruebas de funcionamiento accediendo al contenedor web:

```bash
docker exec -it container_php bash
php ./pruebas/pruebas_admin.php
php ./pruebas/pruebas_plato.php
```

---

## 🧼 Cómo apagar todo

Cuando termines de usar la aplicación, puedes apagar todo con:

```bash
docker-compose down
```

Y si quieres eliminar también los datos y los contenedores:

```bash
docker-compose down -v
```


---

## 📌 Notas finales

- Asegúrate de que Docker esté abierto antes de ejecutar los comandos.
- Este proyecto está pensado para funcionar de forma local con Docker, no requiere instalar Apache ni MySQL manualmente.