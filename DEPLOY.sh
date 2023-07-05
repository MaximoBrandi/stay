#!/bin/bash

echo "Este programa requiere tener instalado de antemano httpd, php, composer, mysql/mariadb y npm, ejecutara una verificacion antes de empezar el despliegue"

# Preguntar al usuario si desea continuar o no
read -p "¿Desea continuar con la verificacion? (y/n): " respuesta

# Validar la respuesta
case $respuesta in
    [yY]* ) # Si la respuesta empieza con y o Y, continuar el código
        # Verificar la existencia de los comandos
        if ! command -v php &> /dev/null; then
            echo "El comando php no está instalado"
            # Aquí puedes hacer x código para instalar php o salir del script
        else
            echo "El comando php está instalado"
        fi

        if ! command -v composer &> /dev/null; then
            echo "El comando composer no está instalado"
            # Aquí puedes hacer x código para instalar composer o salir del script
        else
            echo "El comando composer está instalado"
        fi

        if ! command -v npm &> /dev/null; then
            echo "El comando npm no está instalado"
            # Aquí puedes hacer x código para instalar npm o salir del script
        else
            echo "El comando npm está instalado"
        fi

        if ! command -v nano &> /dev/null; then
            echo "El comando nano no está instalado"
            # Aquí puedes hacer x código para instalar nano o salir del script
        else
            echo "El comando nano está instalado"
        fi

        # Verificar que los servicios están en ejecución
        if ! systemctl is-active --quiet httpd; then
            echo "El servicio httpd no está en ejecución"
            # Aquí puedes hacer x código para iniciar httpd o salir del script
        else
            echo "El servicio httpd está en ejecución"
        fi

        if ! systemctl is-active --quiet mariadb; then
            echo "El servicio mariadb no está en ejecución"
            # Aquí puedes hacer x código para iniciar mariadb o salir del script
        else
            echo "El servicio mariadb está en ejecución"
        fi

        # Continuar con el resto del código
        echo "Todo listo!"

        ;;
    [nN]* ) # Si la respuesta empieza con n o N, terminar la ejecución del código
        echo "Terminando la ejecución del código..."
        exit 0
        ;;
    * ) # Si la respuesta es otra cosa, mostrar un mensaje de error y volver a preguntar
        echo "Respuesta inválida. Por favor, ingrese y o n."
        # Llamar al mismo script de nuevo para repetir la pregunta
        $0
        ;;
esac

composer install

npm install

npm audit fix

cp .env.example .env

cp examples/* storage/app/public/

php artisan key:generate

nano .env

php artisan migrate:fresh --seed

echo "Todavia tienes que en esta misma ruta en otra consola ejecutar 'npm run dev' antes de utilizar la aplicacion"

php artisan serve
