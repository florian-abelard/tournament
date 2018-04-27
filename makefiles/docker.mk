#------------------------------------------------------------------------------
# Docker Makefile
#------------------------------------------------------------------------------

#------------------------------------------------------------------------------

build: ##@docker build containers
	docker-compose -f ${DOCKER_COMPOSE_FILE} build

up: ##@docker create and start containers
	docker-compose -f ${DOCKER_COMPOSE_FILE} up -d

down: ##@docker stop and remove containers and volumes
	docker-compose -f ${DOCKER_COMPOSE_FILE} down --volumes

connect: ##@docker open a bash session in the web container
	docker-compose -f ${DOCKER_COMPOSE_FILE} exec web /bin/bash

#------------------------------------------------------------------------------

clean-docker: down ##@docker clean docker containers
	docker rmi flo/tournoi:develop

#------------------------------------------------------------------------------

.PHONY: up build down connect clean-docker
