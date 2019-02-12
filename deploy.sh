#!/bin/bash

## Deploy dev branch to development server
if [[ "$TRAVIS_BRANCH" -eq "dev" ]]; then
    ## Trigger deployment
    curl -s 'https://forge.laravel.com/servers/264031/sites/705525/deploy/http?token='"$FORGE_DEVELOPMENT_TOKEN";
    echo 'Deployed to Forge - Development'
## Deploy master branch to production server
elif [[ "$TRAVIS_BRANCH" -eq "master" ]]; then
    ## Trigger deployment
    curl -s 'https://forge.laravel.com/servers/263849/sites/704463/deploy/http?token='"$FORGE_PRODUCTION_TOKEN";
    echo 'Deployed to Forge - Production'
fi