#!/bin/bash

success=0
error=1

OUT_COLOR_RED='\033[0;31m'
OUT_COLOR_GREEN='\033[0;32m'
OUT_COLOR_BLUE='\033[0;34m'
OUT_NO_COLOR='\033[0m'

# вывод цветного сообщения
function output() {
  case $2 in
    success)
      echo -e "$OUT_COLOR_GREEN$1$OUT_NO_COLOR"
      ;;
    error)
      echo -e "$OUT_COLOR_RED$1$OUT_NO_COLOR"
      ;;
    * | info)
      echo -e "$OUT_COLOR_BLUE$1$OUT_NO_COLOR"
    ;;
  esac
}

function yesno() {
  default=''
  if [[ ! (-z $2)  ]]; then
   default=" [$2]"
  fi
  question="$1 (y/n)${default}:"
  while true; do
    read -p "${question}" answer
    if [[ ${answer} = "" ]]; then
        answer=$2
    fi
    case ${answer} in
      Y | y | yes ) return ${success};;
      N | n | no ) return ${error};;
      * ) echo "Please answer yes or no.";;
    esac
  done
}


# запуск docker-compose
function makeDocker() {

  if ! (docker info); then
    output "docker is not running. Can not continue" error
    return ${error}
  fi
  if ! (hash docker-compose 2>/dev/null); then
    output "docker-compose is not running. Can not continue." error
    return ${error}
  fi
  if ! [[ -f 'docker-compose.yml' ]]; then
    output "docker-compose.yml not found. Can not continue." error
    return ${error}
  fi
  if ! (docker volume inspect le_shop_pg_data >/dev/null); then
    docker volume create --name=le_shop_pg_data
  fi

  if ! (docker network inspect le_shop_network >/dev/null); then
        docker network create --gateway 175.10.10.1 --subnet 175.10.10.0/24 le_shop_network
  fi

  if ! docker-compose up -d; then
    output "docker-compose could not" error
    return ${error}
  fi

  output "Docker containers have been set up successfully." success
  return ${success}
}

function buildLeView() {
    docker-compose up -d node
    docker exec le_shop_node /bin/bash -c "npm run build";
}

function installLeView() {
    docker-compose up -d node
    docker exec le_shop_node /bin/bash -c "npm install; npm update && run build";
}

function buildLeShopPhp() {
    output "Setting up php with composer" info

    docker exec le_shop_php /bin/bash -c "composer install --ignore-platform-reqs &&
      php init --env=Development &&
      php yii migrate --interactive=0 &&
      php yii migrate-rbac --interactive=0 &&
      php yii_test migrate --interactive=0
    "

    output "Setup successful" success

}

function runUnits() {
    output "Running units" info

    docker exec le_shop_php /bin/bash -c "php yii_test migrate --interactive=0 &&
        vendor/bin/codecept run unit -c frontend ;
        vendor/bin/codecept run unit -c backend ;
        vendor/bin/codecept run unit -c common
    "
}

function generateUnitTest() {
  output 'Please select the directory to create test in:'

    FRONTEND_DIR='frontend'
    BACKEND_DIR='backend'
    COMMON_DIR='common'

    CHOSEN_DIR=''

    options=(
      "${FRONTEND_DIR}"
      "${BACKEND_DIR}"
      "${COMMON_DIR}"
    )

    select opt in "${options[@]}"; do
      case ${opt} in
      ${FRONTEND_DIR})
        CHOSEN_DIR="${FRONTEND_DIR}"
        break
        ;;
      ${BACKEND_DIR})
        CHOSEN_DIR="${BACKEND_DIR}"
        break
        ;;
      ${COMMON_DIR})
        CHOSEN_DIR="${COMMON_DIR}"
        break
        ;;
      *)
        output 'Choose one of the shown options:' error
        generateUnitTest
        break
        ;;
      esac
    done

    read -p "Enter the test name (e.g. model/LoginForm): " TEST_NAME

    docker exec le_shop_php /bin/bash -c "vendor/bin/codecept --config=${CHOSEN_DIR} g:test unit ${TEST_NAME}
    "

}

function initialiseApi() {
  output "updating laravel packages" info
    docker exec le_shop_php bash -c "cd api && composer update"
  output "updating laravel packages successful" success

  output "generating api laravel encryption key" info
    docker exec le_shop_php bash -c "cd api && php artisan key:generate"
  output "key generation successful" success

  output "running laravel migrations" info
    docker exec le_shop_php bash -c "cd api && php artisan migrate"
  output "laravel migrations successful" success

  output "running laravel migrations" info
    docker exec le_shop_php bash -c "cd api && php artisan migrate --database='pgsqlTest'"
  output "laravel migrations successful" success

  output "installing laravel passport" info
    docker exec le_shop_php bash -c "cd api && php artisan passport:install"
  output "laravel passport installation successful" success

  sudo chmod -R 777 api/storage/logs
  sudo chmod -R 777 api/storage/framework

#  output "creating oauth2 client record" info
#    # checking if this record exists already
#    QUERY_RESULT=$(docker exec -it le_shop_pgsql bash -c 'psql -d le_shop -U le_shop -c "select count(id) from oauth_clients where id=4 and personal_access_client=true"')
#    # if we didn't find the row with id=4 and personal_client, then we run a script which creates one for us.
#    if [ ! $(grep -c "(1 row)" ${QUERY_RESULT}) -eq 1 ]; then
#      docker exec -it le_shop_pgsql bash -c "psql -d le_shop -U le_shop -a -f /var/www/le_shop/docker/postgres/create_client.sql"
#    fi
#    # in the Vue's storage AuthStore the client credentials are hardcoded, there is no way to take them out to some
#    # .env file or anything, so we also hardcoded them in the insertion script... anyway, it is another todo: decouple this
#  output "oauth2 client created successfully" success
#  output "remember to check the Vue AuthStore to include the right info" error

  docker exec le_shop_php bash -c "cd .."

}

######################################
function checkHosts() {
    HOSTS='127.0.0.1 backend.le.shop le.shop view.le.shop api.le.shop'
    if grep "${HOSTS}" /etc/hosts | grep -v '^#'; then
      echo "${HOSTS} уже присутствуют в /etc/hosts"
    else
      sudo /bin/bash -c "echo -e '\n${HOSTS}' >> /etc/hosts";
      output "${HOSTS} have been added successfully to /etc/hosts." success
    fi
    output "The sites are available at \n " info
    output "backend.le.shop:20080 " info
    output 'le.shop:20080 ' info
    output 'view.le.shop:20080 ' info
    output 'api.le.shop:20080 ' info
    output 'Also a development server for Vuetify is running on: ' success
    output 'view.le.shop:23000 ' info
}


function fullInstall() {
    copyEnv
    if ! makeDocker; then
        return
    fi
    installLeView
    buildLeShopPhp
    initialiseApi
    checkHosts
}

function start() {
    docker-compose up -d
}

function copyEnv() {
  if ! [[ -f '.env' ]]; then
      cp .example.env .env
  fi
}

function showInstallMenu() {
  INSTALL='Full project installation'
  START='Start the containers'
  LE_VIEW_BUILD='Build le view'
  LE_SHOP_PHP_BUILD='Set up php of le shop with composer'
  RUN_UNITS='Run codeception unit tests'
  GENERATE_UNIT='Generate a new unit test'

  options=(
      "${INSTALL}"
      "${START}"
      "${LE_VIEW_BUILD}"
      "${LE_SHOP_PHP_BUILD}"
      "${RUN_UNITS}"
      "${GENERATE_UNIT}"
  )

    select opt in "${options[@]}"; do
      case ${opt} in
      ${INSTALL})
        output "Full project installation" success
        fullInstall
        return
        ;;
      ${START})
        start
        return
        ;;
      ${LE_VIEW_BUILD})
        buildLeView
        return
        ;;
      ${LE_SHOP_PHP_BUILD})
        buildLeShopPhp
        return
        ;;
      ${RUN_UNITS})
        runUnits
        return
        ;;
      ${GENERATE_UNIT})
        generateUnitTest
        return
        ;;
      *)
    output 'Choose one of the shown options:' error
    showInstallMenu
    return
      ;;
    esac
  done
}

showInstallMenu


