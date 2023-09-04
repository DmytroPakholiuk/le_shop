#!/bin/bash

success=0
error=1

OUT_COLOR_RED='\033[0;31m'
OUT_COLOR_GREEN='\033[0;32m'
OUT_COLOR_BLUE='\033[0;34m'
OUT_NO_COLOR='\033[0m'
CI_PROJECT_DIR='/builds/gomer/lisa'

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
    output "docker не запущен. Продолжить невозможно." error
    return ${error}
  fi
  if ! (hash docker-compose 2>/dev/null); then
    output "docker-compose не запущен. Продолжить настройку невозможно." error
    return ${error}
  fi
  if ! [[ -f 'docker-compose.yml' ]]; then
    output "Не найден файл docker-compose.yml. Продолжить настройку невозможно." error
    return ${error}
  fi
  if ! [[ -f './docker/.bash_history' ]]; then
    touch ./docker/.bash_history
  fi

  if ! (docker volume inspect lisa-pg-data >/dev/null); then
    docker volume create --name=lisa-pg-data
  fi
  if ! (docker volume inspect splitter-mysql-data >/dev/null); then
    docker volume create --name=splitter-mysql-data
  fi

  if ! (docker network inspect lisa_splitter_network >/dev/null); then
    docker network create --driver=bridge --subnet=130.10.1.0/24 lisa_splitter_network
  fi

  if ! USER_ID=$(id -u ${USER}) GROUP_ID=$(id -g ${USER}) docker-compose up -d; then
    output "docker-compose не смог" error
    return ${error}
  fi

  output "Сборка и запуск докер контейнеров прошли успешно." success
  return ${success}
}

function showSplitterSettingsMenu() {
  CONTINUE='Продолжить и не трогать splitter'
  COMPOSER_INSTALL='Запустить composer install для проекта splitter'
  COMPOSER_UPDATE='Запустить composer update для проекта splitter'
  DROP_AND_REINSTALL='Удалить проект splitter и поставить заново'

  options=(
    "${CONTINUE}"
    "${COMPOSER_INSTALL}"
    "${COMPOSER_UPDATE}"
    "${DROP_AND_REINSTALL}"
  )

  select opt in "${options[@]}"; do
    case ${opt} in
    ${CONTINUE})
      output "Продолжаем" success
      return
      ;;
    ${COMPOSER_INSTALL})
      splitterComposerInstall
      return
      ;;
    ${COMPOSER_UPDATE})
      docker-compose exec lisa-php /bin/bash -c "cd splitter/www && composer update --ignore-platform-reqs"
      return
      ;;
    ${DROP_AND_REINSTALL})
      output "удаляем папку ./splitter/www" success
      sudo rm -rf ./splitter/www
      installSplitter
      return
      ;;
    *)
      output 'Выберите один из предложенных вариантов' error
      showSplitterSettingsMenu
      return
        ;;
      esac
    done
}

function installSplitter() {
  output "Настройка splitter" info

  if [[ -d './splitter/www' ]]; then
    output "Директория ./splitter/www существует" success
    showSplitterSettingsMenu
    return
  fi

  docker-compose exec lisa-php /bin/bash -c "cd splitter &&
  git clone git@gitlab.rozetka.company:splitter-team/splitter.base.git www &&
  cd www &&
  php init --env=Development &&
  composer install --ignore-platform-reqs &&
  composer require --ignore-platform-reqs yiisoft/yii2-httpclient:2.0.13 &&
  cp -f ${CI_PROJECT_DIR}/api/main-local.spl.txt ${CI_PROJECT_DIR}/splitter/www/backend/config/main-local.php &&
  cp -f ${CI_PROJECT_DIR}/api/example.spl.env ${CI_PROJECT_DIR}/splitter/www/.env &&
  php yii migrate --interactive=0 &&
  sed -i 's|\$task->populateRelation|//\$task->populateRelation|' ${CI_PROJECT_DIR}/splitter/www/vendor/splitter-modules/splitter.core/system/components/cronManager/CronTaskComponent.php"

  if (yesno "Создать пользователя сплиттер?" yes); then
   docker-compose exec lisa-php /bin/bash -c "cd splitter/www && php yii user/admin/add"
  fi
}

function showLisaSettingsMenu() {
  CONTINUE='Продолжить и не трогать lisa'
  COMPOSER_INSTALL='Запустить composer install для lisa'
  COMPOSER_UPDATE='Запустить composer update для lisa'

  options=(
    "${CONTINUE}"
    "${COMPOSER_INSTALL}"
    "${COMPOSER_UPDATE}"
  )

  select opt in "${options[@]}"; do
    case ${opt} in
    ${CONTINUE})
      output "Продолжаем" success
      return
      ;;
    ${COMPOSER_INSTALL})
      lisaComposerInstall
      return
      ;;
    ${COMPOSER_UPDATE})
      docker-compose exec lisa-php /bin/bash -c "cd api && composer update --ignore-platform-reqs"
      return
      ;;
    *)
      output 'Выберите один из предложенных вариантов' error
      showLisaSettingsMenu
      return
        ;;
      esac
    done
}

function installLisa() {
    output "Настройка Lisa" info
    #copy public jwt if not exists
    if [[ -f './api/config/jwt/public.pem' ]]; then
      output "Копируем jwt-токен" info
      docker-compose exec lisa-php /bin/bash -c "mkdir ${CI_PROJECT_DIR}/api/config/jwt &&
        cp ${CI_PROJECT_DIR}/splitter/www/backend/runtime/jwt-rsa.pub ${CI_PROJECT_DIR}/api/config/jwt/public.pem"
    fi

    if [[ -f './api/.env' ]]; then
      output "Lisa api настроен" success
      showLisaSettingsMenu

      if (yesno "запустить npm install и npm?" yes); then
         buildNpm
      fi
      return
    fi

    docker-compose exec lisa-php /bin/bash -c "cd ${CI_PROJECT_DIR}/api &&
    composer install --ignore-platform-reqs &&
    cp example.env .env &&
    php yii migrate --interactive=0 &&
    php tests/bin/yii migrate --interactive=0 &&
    php yii user/create-admin-user"

    buildNpm
}

function buildNpm() {
    docker-compose exec lisa-php /bin/bash -c "npm install && npm run build";
    #docker-compose exec lisa-php /bin/bash -c "cd ${CI_PROJECT_DIR}/api && php yii command/update-manifest";
    output "ОБНОВИТЕ МАНИФЕСТ НА СТРАНИЦЕ:" info
    echo "http://splitter.docker:8081/system/module-dispatcher/versions-list?id=lisa"
    echo "После этого Lisa будет доступна по адресу:"
    echo "http://splitter.docker:8081/lisa/#/request/list/all"
}

function checkHosts() {
    HOSTS='127.0.0.1 splitter.docker lisa-api.docker lisa-client.docker minio.docker'
    if grep "${HOSTS}" /etc/hosts | grep -v '^#'; then
      echo "${HOSTS} уже присутствуют в /etc/hosts"
    else
      sudo /bin/bash -c "echo -e '\n${HOSTS}' >> /etc/hosts";
      output "${HOSTS} успешно добавлены в /etc/hosts." success
    fi
}

function fullInstall() {
    if ! makeDocker; then
        return
    fi
    installSplitter
    installLisa
    checkHosts
}

function splitterComposerInstall() {
  docker-compose exec lisa-php /bin/bash -c "cd splitter/www && composer install --ignore-platform-reqs"
}

function splitterMigrate() {
    docker-compose exec lisa-php /bin/bash -c "cd splitter/www && php yii migrate --interactive=0"
}

function lisaComposerInstall() {
  docker-compose exec lisa-php /bin/bash -c "cd api && composer install --ignore-platform-reqs"
}

function lisaMigrate() {
    docker-compose exec lisa-php /bin/bash -c "cd api && php yii migrate --interactive=0"
}

function lisaUnits() {
    docker-compose exec lisa-php /bin/bash -c "cd api &&
      php tests/bin/yii migrate --interactive=0 &&
      vendor/bin/codecept run unit"
}

function start() {
  docker pull registry.gitlab.rozetka.company/common/ci-docker-images/ci-php74
  USER_ID=$(id -u ${USER}) GROUP_ID=$(id -g ${USER}) docker-compose up -d
  docker exec lisa-php /bin/bash -c "sudo -E docker-php-ext-enable xdebug && sudo pkill -USR2 -f \"php-fpm: master\""
  docker exec -it lisa-php /bin/bash
}

function showInstallMenu() {
  INSTALL='Полная установка проекта'
  START='Старт контейнеров'
  SPLITTER_COMPOSER_INSTALL='Запустить composer install для Splitter'
  SPLITTER_MIGRATE='Запустить миграции для Splitter'
  LISA_COMPOSER_INSTALL='Запустить composer install для Lisa'
  LISA_MIGRATE='Запустить миграции для Lisa'
  LISA_NPM='Сбилдить npm'
  LISA_UNITS='Запустить юниты'

  options=(
      "${INSTALL}"
      "${START}"
      "${SPLITTER_COMPOSER_INSTALL}"
      "${SPLITTER_MIGRATE}"
      "${LISA_COMPOSER_INSTALL}"
      "${LISA_MIGRATE}"
      "${LISA_NPM}"
      "${LISA_UNITS}"
  )

    select opt in "${options[@]}"; do
      case ${opt} in
      ${INSTALL})
        output "Полная установка проекта" success
        fullInstall
        return
        ;;
      ${START})
        start
        return
        ;;
      ${SPLITTER_COMPOSER_INSTALL})
        splitterComposerInstall
        return
        ;;
      ${SPLITTER_MIGRATE})
        splitterMigrate
        return
        ;;
      ${LISA_COMPOSER_INSTALL})
        lisaComposerInstall
        return
        ;;
      ${LISA_MIGRATE})
        lisaMigrate
        return
        ;;
      ${LISA_NPM})
        buildNpm
        return
        ;;
      ${LISA_UNITS})
        lisaUnits
        return
        ;;
      *)
    output 'Выберите один из предложенных вариантов' error
    showLisaSettingsMenu
    return
      ;;
    esac
  done
}

showInstallMenu