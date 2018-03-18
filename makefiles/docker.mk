#------------------------------------------------------------------------------
# Docker Makefile
#------------------------------------------------------------------------------

DOCKER_COMPOSE_FILE?=docker/docker-compose.yml

#------------------------------------------------------------------------------

build: ##@docker build containers
	docker-compose -f ${DOCKER_COMPOSE_FILE} build

up:
	docker-compose -f ${DOCKER_COMPOSE_FILE} up -d

down:
	docker-compose -f ${DOCKER_COMPOSE_FILE} down --volumes

attach:
	docker-compose -f ${DOCKER_COMPOSE_FILE} exec web /bin/bash

#------------------------------------------------------------------------------

clean-docker: down
	docker rmi flo/tournoi:develop

#------------------------------------------------------------------------------

.PHONY: up build down attach clean-docker ## eqs ezs f
