#Install process

##Composer

###Installing composer
*If you have Composer already installed, go to next step.* The commands are the one for Linux (working on Ubuntu Server [Source](https://getcomposer.org/doc/00-intro.md#installation-nix)) 

```
#Command line for a global install, you need `php5-cli` installed
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

###Running composer
**Warning for fresh Server instance** : One of the dependency of authbucket, guzzle, need curl extension for php. To install it, do `sudo apt-get install php5-curl` on a linux machine
In the root directory of this git, do `composer install`