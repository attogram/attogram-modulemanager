# Attogram Framework Module Manager v0.0.1

[![Latest Stable Version](https://poser.pugx.org/attogram/attogram-modulemanager/v/stable)](https://packagist.org/packages/attogram/attogram-modulemanager)
[![Latest Unstable Version](https://poser.pugx.org/attogram/attogram-modulemanager/v/unstable)](https://packagist.org/packages/attogram/attogram-modulemanager)
[![Total Downloads](https://poser.pugx.org/attogram/attogram-modulemanager/downloads)](https://packagist.org/packages/attogram/attogram-modulemanager)
[![License](https://poser.pugx.org/attogram/attogram-modulemanager/license)](https://github.com/attogram/attogrammodulemanager/blob/master/LICENSE.md)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/91c50120add44e26bd22e605849e673b)](https://www.codacy.com/app/attogram-project/attogram-modulemanager?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=attogram/attogram-modulemanager&amp;utm_campaign=Badge_Grade)
[![Code Climate](https://codeclimate.com/github/attogram/attogram-modulemanager/badges/gpa.svg)](https://codeclimate.com/github/attogram/attogram-modulemanager)
[![Issue Count](https://codeclimate.com/github/attogram/attogram-modulemanager/badges/issue_count.svg)](https://codeclimate.com/github/attogram/attogram-modulemanager)
[`[CHANGELOG]`](https://github.com/attogram/attogram-modulemanager/blob/master/CHANGELOG.md)
[`[TODO]`](https://github.com/attogram/attogram-modulemanager/blob/master/TODO.md)

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
