#!/usr/bin/env bash

## Deploy dev branch to development server
curl "'https://forge.laravel.com/servers/264031/sites/705525/deploy/http?token='$FORGE_DEVELOPMENT_TOKEN";
echo 'Deployed to Forge - Development';