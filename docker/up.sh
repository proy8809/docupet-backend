#!/bin/bash

NETWORK=docupet

if ! docker network inspect "${NETWORK}" >/dev/null 2>&1; then
    docker network create --driver bridge ${NETWORK}
fi

docker compose up -d --force-recreate --build
