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

##Database
From your git directory :
```shell
cd install
mysql -uRootMySQL -pPasswordRootMySql < ./database.sql
php ../vendor/bin/doctrine orm:schema-tool:create
```

##Testing the oAuth
- http://oauth.perseids.org/api/v1.0/oauth2/authorize
```json
{
  'client_id' : 'implicit_grant'
  'redirect_uri' : 'http://oauth.perseids.org'
  'response_type' : 'token'
  'scope' : 'demoscope1 demoscope2 demoscope3'
  'state' : 'olcvl4u3vltckpua6hrm4s6b11'
}
```

##Deploy  on AWS
Follow [AWS EB Client](http://docs.aws.amazon.com/elasticbeanstalk/latest/dg/eb-cli3-getting-set-up.html)