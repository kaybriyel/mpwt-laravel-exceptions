# Setup

## Initialize Git Repo

```bash
git init .
```

## Initialize Composer Project

```bash
composer init
```

```bash
root@c2936624bfa7:/var/www/packages/mpwt/exceptions# composer init
PHP Warning:  Module "oci8" is already loaded in Unknown on line 0

                                            
  Welcome to the Composer config generator  
                                            


This command will guide you through creating your composer.json config.

Package name (<vendor>/<name>) [root/exception]: mpwt/exceptions
Description []: MPWT Standard Exception Handling   
Author [n to skip]: Kay Briyel
Minimum Stability []: dev
Package Type (e.g. library, project, metapackage, composer-plugin) []: library
License []: MIT

Define your dependencies.

Would you like to define your dependencies (require) interactively [yes]? no
Would you like to define your dev dependencies (require-dev) interactively [yes]? no
Add PSR-4 autoload mapping? Maps namespace "Mpwt\Exception" to the entered relative path. [src/, n to skip]: 

{
    "name": "mpwt/exceptions",
    "description": "MPWT Standard Exception Handling",
    "type": "library",
    "license": "MIT",
    "autoload": {
        "psr-4": {
            "Mpwt\\Exceptions\\": "src/"
        }
    },
    "authors": [
        {
            "name": "Kay Briyel"
        }
    ],
    "minimum-stability": "dev",
    "require": {}
}

Do you confirm generation [yes]? 
Generating autoload files
Generated autoload files
PSR-4 autoloading configured. Use "namespace Mpwt\Exceptions;" in src/
Include the Composer autoloader with: require 'vendor/autoload.php';
```