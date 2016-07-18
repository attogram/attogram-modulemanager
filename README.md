# Attogram Framework Module Manager v0.0.1

This is the [Module Manager](https://github.com/attogram/attogram-modulemanager)
for the [Attogram Framework](https://github.com/attogram/attogram).

The Module Manager is a web interface that allows admins to:

* View status of modules
* Disable modules
* Enable modules

## Install via composer

```
cd your-attogram-install-directory
composer create-project attogram/attogram-modulemanager modules/modulemanager
```

## Install manually

* download latest
  [Module Manager ZIP distrubtion](https://github.com/attogram/attogram-modulemanager/archive/master.zip)
* unzip and move the managermodule directory into
  your Attogram installation  `modules/` directory

## Permissions

Your web server must have read/write permission to the
Attogram installation `modules/` and `modules_disabled/` directories
in order for the Module Manager to work properly.

## Module Manager contents

### Admin Actions

* [`admin_actions/module-admin.php`](https://github.com/attogram/attogram-modulemanager/blob/master/admin_actions/module-admin.php) - Module Manager Admin Page

### Included Files

* [`includes/ModuleManager.php`](https://github.com/attogram/attogram-modulemanager/blob/master/includes/moduleManager.php) - Attogram ModuleManager Object
