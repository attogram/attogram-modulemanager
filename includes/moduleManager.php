<?php
// Attogram Framework - ModuleManager class v0.0.2

namespace Attogram;

class ModuleManager
{
    public $attogram; // (object) Attogram Framework Object
    public $modules;  // (array) memory variable for getModuleList()

    public function __construct($attogram)
    {
        $this->attogram = $attogram;
    }

    public function getModuleList($directory)
    {
        $this->modules = array();
        $directories = array_diff(
            scandir($directory),
            $this->attogram->getSkipFiles()
        );
        foreach ($directories as $dir) {
            $moduleDirectory = $directory.DIRECTORY_SEPARATOR.$dir;
            if (!is_dir($moduleDirectory)) {
                continue;
            }
            if (!is_readable($moduleDirectory)) {
                continue;
            }
            $this->modules[$dir] = $moduleDirectory;
        }
        $this->attogram->log->debug('getModuleList: ' . $directory, $this->modules);
        return $this->modules;
    }

    public function enable($module)
    {
        $result = 'ENABLING: ' . $this->attogram->webDisplay($module);
        // check module exists
        // check module in /modules_disabled/*
        // check name is free in enabled /modules/*
        // rename to /modules/*

        return $result;
    }

    public function disable($module)
    {
        $result = 'DISABLING: ' . $this->attogram->webDisplay($module);
        // check module exists
        // check module in /modules/*
        // check name is free in /modules_disabled/*
        // rename to /modules_disabled/*
        return $result;
    }
}
