# Skihut
[![Build Status](https://travis-ci.org/ThijsBouwes/skihut.svg?branch=master)](https://travis-ci.org/ThijsBouwes/skihut)
[![NL](https://img.shields.io/badge/Made%20in-NL-blue.svg)](https://computer4life.nl)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

Powered by Thijs Bouwes & Laravel.
## Setup
* Pull in this repo
* Copy the `cp .env.example .env` and configure it
* Run `composer install && npm install && npm run dev && php artisan migrate`
* Now we need to setup Laravel Passport with `php artisan passport:client --password`
* Copy the generated id + key to the `.env CLIENT_ID & CLIENT_SECRET`
* Make sure to link the storage folder `php artisan storage:link`
* Setup the scheduler in a cron `* * * * * php /path-to-your-wproject/artisan schedule:run >> /dev/null 2>&1`
* Also make sure to configure the Supervisor for queues [Laravel queues - supervisor config](https://laravel.com/docs/5.6/queues#supervisor-configuration)

## Overview
Skihut is an application to manage your social group, the application main focus is to facilitate in the following cases:
- [x] Users 
- [x] Expenses
- [x] Income
- [x] Stock
- [x] Events
- [x] Dashboard with all the stats

The idea is to have a single application running, in the application you can manage all the entities and view the results.

### Features
* Send welcome mail
* Send weekly invoices
* Overview with user debts
* Admin / user authorization 

## Run tests
Todo

## Swagger docs
Todo

## Contributions
If you wish to notify us of a bug or want to have a new feature implemented, go to [our Issues page](https://github.com/ThijsBouwes/skihut/issues). Do a search if yours has not been logged by someone else before creating a new issue.

GitHub has provided a [handy guide](https://opensource.guide/) on how to help out if you're new to contributing to open source projects.