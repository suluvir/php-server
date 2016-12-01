# Suluvir

This repository contains the server for the suluvir self hosted music streaming service.

## Build status

[![Build Status](https://travis-ci.org/suluvir/server.svg?branch=master)](https://travis-ci.org/suluvir/server)

## Setup

1. Get [Composer](https://getcomposer.org/)
1. Install dependencies by running `composer install`
1. Copy `suluvir.default.ini` to `suluvir.ini` and tweak its settings according to your needs
1. Run `composer create-db` to create the database tables
1. (Optional) Make sure everything works by running `composer test`
