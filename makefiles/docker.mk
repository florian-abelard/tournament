#------------------------------------------------------------------------------
# Docker Makefile
#------------------------------------------------------------------------------

docker-compose-exec = docker-compose -f ${DOCKER_COMPOSE_FILE} exec -T --user www-data web ${1}

#------------------------------------------------------------------------------

build: ##@docker build containers
	docker-compose -f ${DOCKER_COMPOSE_FILE} build

up: .env ##@docker build and start containers
	docker-compose -f ${DOCKER_COMPOSE_FILE} up -d

down: ##@docker stop and remove containers and volumes
	docker-compose -f ${DOCKER_COMPOSE_FILE} down --volumes

rebuild: build up ##@docker rebuild and start containers

connect: ##@docker open a bash session in the web container
	docker-compose -f ${DOCKER_COMPOSE_FILE} exec web /bin/bash

#------------------------------------------------------------------------------

clean-docker: down ##@docker clean docker containers
	docker rmi flo/tournoi:develop

#------------------------------------------------------------------------------

.PHONY: up build down connect clean-docker
