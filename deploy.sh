#!/bin/sh
#
# Deploy Script
#
# Deploy .\dist folder as static site to heroku
#

# Colors
COLOR_OFF="\033[0m"   # unsets color to term fg color
GREEN="\033[0;32m"    # green
CYAN="\033[0;36m"     # cyan
HEROKU_REMOTE="https://git.heroku.com/hyp3r-docs.git"

echo "\n${GREEN}BUILD PROJECT${COLOR_OFF}\n"
# build project
npm run build

# push to heroku
echo "\n${GREEN}DEPLOYING API CORE DOCUMENTATION TO HEROKU${COLOR_OFF}\n"
cd dist
git init
git remote add heroku $HEROKU_REMOTE
git add .
git commit -m "Updated at `date +'%Y-%m-%d %H:%M:%S'`"
git push heroku master --force
echo "\n${CYAN}APP DEPLOYED!${COLOR_OFF}\n"