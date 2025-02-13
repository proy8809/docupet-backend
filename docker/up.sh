#!/bin/bash

NETWORK=docupet

cp .env.example .env
cp ../src/.env.example ../src/.env

if ! docker network inspect "${NETWORK}" >/dev/null 2>&1; then
    docker network create --driver bridge ${NETWORK}
fi

docker compose -p docupet-backend up -d --force-recreate --build
