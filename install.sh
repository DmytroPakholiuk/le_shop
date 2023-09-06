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
      php yii migrate-rbac --interactive=0
    "

    output "Setup successful" success

}

######################################
function checkHosts() {
    HOSTS='127.0.0.1 backend.le.shop le.shop view.le.shop'
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
}


function fullInstall() {
    copyEnv
    if ! makeDocker; then
        return
    fi
    installLeView
    buildLeShopPhp
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

  options=(
      "${INSTALL}"
      "${START}"
      "${LE_VIEW_BUILD}"
      "${LE_SHOP_PHP_BUILD}"
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
      *)
    output 'Choose one of the shown options:' error
    showInstallMenu
    return
      ;;
    esac
  done
}

showInstallMenu


