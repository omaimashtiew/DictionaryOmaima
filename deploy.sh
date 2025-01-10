#!/bin/bash
# Pull the latest code
git pull origin main

# Stop and remove running containers
docker-compose down

# Build and run containers
docker-compose up -d --build
