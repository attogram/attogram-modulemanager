<?php
// Attogram Framework - ModuleManager class v0.0.3

namespace Attogram;

class ModuleManager
{
    public $attogram;           // (object) Attogram Framework Object
    public $modules;            // (array) memory variable for getModuleList()
    public $enabledModulesDir;  // (string) Modules Directory
    public $enabledModules;     // (array) memory variable for getEnabledModuleList()
    public $disabledModulesDir; // (string) Disabled Modules directory
    public $disabledModules;    // (array) memory variable for getDisabledModuleList()

    public function __construct($attogram)
    {
        $this->attogram = $attogram;
        $this->enabledModulesDir = $this->attogram->modulesDirectory;
        $this->disabledModulesDir = dirname($this->enabledModulesDir)
            .DIRECTORY_SEPARATOR.'modules_disabled';
    }

    public function getEnabledModuleList()
    {
        if (is_array($this->enabledModules)) {
            return $this->enabledModules;
        }
        return $this->enabledModules = $this->getModuleList($this->enabledModulesDir);
    }

    public function getDisabledModuleList()
    {
        if (is_array($this->disabledModules)) {
            //return $this->disabledModules;
        }
        return $this->disabledModules = $this->getModuleList($this->disabledModulesDir);
    }

    private function getModuleList($directory)
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
