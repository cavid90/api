#!/bin/bash

# Check of git package and install if does not exist
dpkg -l | grep -qw git || apt-get -y install git

# Clone repository for github to home/javid-api
git clone https://github.com/cavid90/api.git /home/javid-api

# go to the directory
cd /home/javid-api

# Run docker compose for http://localhost:8080
docker-compose up -d