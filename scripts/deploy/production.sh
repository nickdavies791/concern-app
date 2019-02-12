#!/usr/bin/env bash

## Deploy master branch to production server
curl "'https://forge.laravel.com/servers/263849/sites/704463/deploy/http?token='$FORGE_PRODUCTION_TOKEN";
echo 'Deployed to Forge - Production';