# Docker-Laravel-React
This is a repository for a technical test for the company TechPump. It is an application in laravel backend and react frontend. with mysql, everything is dockerized.


#Pasos para ejecutar proyecto (todo desde la raíz)

1.Docker-compose build
2.Docker-compose -up d
3.docker exec techpump-docker-backend-1 php artisan migrate (para ejecutar migraciones necesarios)
4.docker exec techpump-docker-backend-1 php artisan test (para lanzar tests)
