#!/bin/bash

# Trigger deployment
# Replace the url below with your Forge/Laravel url
curl -s ' https://forge.laravel.com/servers/264031/sites/705525/deploy/http?token=UL6uW49Rj3gYWEZ5kPK9TmyVnf2FhVZfLrQtYDqs ';
echo 'Deployed to Forge'