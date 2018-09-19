#!/bin/bash

# Check of git package and install if does not exist
dpkg -l | grep -qw git || apt-get -y install git
sudo mkdir /home/${USER}/javid-api
sudo chmod -R 777 /home/${USER}/javid-api
# Clone repository for github to /home/${USER}/javid-api
git clone https://github.com/cavid90/api.git /home/${USER}/javid-api

# go to the directory
cd /home/${USER}/javid-api

# Run docker compose for http://localhost:8080
docker-compose up -d