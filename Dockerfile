# Use an official PHP Apache image as the base image
FROM php:8.2-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy all files and directories from the project folder into the container
COPY . .

# Expose port 80 (default for Apache)
EXPOSE 80