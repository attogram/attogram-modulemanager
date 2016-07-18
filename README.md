# Attogram Framework Module Manager v0.0.0

This is the [Module Manager](https://github.com/attogram/attogram-modulemanager)
for the [Attogram Framework](https://github.com/attogram/attogram).

## Install via composer

```
cd your-attogram-install-directory
composer create-project attogram/attogram-modulemanager modules/modulemanager
```

## Install manually

* download latest
  [Module Manager ZIP distrubtion](https://github.com/attogram/attogram-modulemanager/archive/master.zip)
* unzip and move the managermodule directory to
  your Attogram installation  `modules/` directory

## Permissions

Your web server must have read/write permission to the
Attogram installation `modules/` and `modules_disabled/` directories
in order for the Module Manager to work properly.

## Module Manager contents

### Admin Actions

* `admin_actions/module-admin.php` - Module Manager Admin Page

### Included Files

* `includes/ModuleManager.php` - Attogram ModuleManager Object
