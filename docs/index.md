PhuninCake
==========

PhuninNode CakePHP plugin wrapper

## Installation ##

Installation is easy with composer just add PhuninCake to your composer.json.

    {
        "require": {
            "wyrihaximus/phunin-cake": "0.1.*"
        }
    }

## Basic usage ##

Simple run the following shell command to start the node server.

    ./cake PhuninCake.node start

Because PhuninCake requires ZMQ it can be stopped by the following command.

    ./cake PhuninCake.node stop