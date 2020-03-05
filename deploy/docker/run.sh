#!/bin/bash

DOCKER_NAME=web_app

sudo docker run -v $(pwd)/../../src/diy_book:/home/webApp --name ${DOCKER_NAME} -it -d -p 8080:80 vreminder:v1