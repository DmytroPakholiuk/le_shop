<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Welcome to the abomination called "Le Shop"</h1>
    <br>

[//]: # (</p>)

The main carcass of the project is [Yii 2](http://www.yiiframework.com/) advanced template.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

Le Shop also has Laravel framework in <code>api/</code> directory, which is supposed to provide 
stateless REST api to the resources.

In <code>le_view</code> directory you will find a Vuetify project.

When deployed in Docker, backend app, frontend app, Laravel API and 
Vuetify are hosted on the same server but different subdomains:

<ol>
    <li><code>backend.le.shop:20080</code> - an admin panel for Le Shop. Pure Yii, classic request-response model</li>
    <li><code>le.shop:20080</code> - a frontend Yii 2 tier of the project. Not developed at all, hence basically useless </li>
    <li><code>api.le.shop:20080</code> - RESTful (?) API built on Laravel. Some security concerns were too hard to implement
        myself, so they might have been omitted</li>
    <li><code>view.le.shop:20080</code> - a Vuetify app. this one is built and deployed on nginx server. Actual building
        takes time, so it does not often show the current state of things.</li>
    <li><code>view.le.shop:23000</code> - a Vuetify app. this one is deployed on Vite development server with hot module reloading. </li>
</ol>



INSTALLATION
------------
To install, you will need to:
<ol>
    <li>Clone from the repository</li>
    <li>Run <code>php init</code> </li>
    <li>Run <code>composer install</code> </li>
    <li>Run <code>composer install</code> for api folder </li>
    <li>Configure db and other things in your main-local configs</li>
    <li>Run <code>php yii migrate</code> for migrations</li>
    <li>Run <code>php yii migrate-rbac</code> for RBAC migrations</li>
    <li>Run <code>php artisan migrate</code> in api directory for Laravel migrations</li>
    <li>The hardest part is to register Vuetify client for Laravel API. You will need to 
        run <code>php artisan passport:client --personal</code> and properly configure it in Vuetify app.</li>
</ol>

<i>It is probable that I made some mistakes making those instructions as I have not done it manually for a while</i>

<b>Alternatively, if you have Linux you can just run install.sh and choose 
the first option. It will deploy the project in docker-compose</b>

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
