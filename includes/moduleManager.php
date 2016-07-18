<?php
// Attogram Framework - ModuleManager class v0.0.5

namespace Attogram;

class ModuleManager
{
    public $attogram;           // (object) Attogram Framework Object
    public $modules;            // (array) memory variable for getModuleList()
    public $enabledModulesDir;  // (string) Modules Directory
    public $enabledModules;     // (array) memory variable for getEnabledModuleList()
    public $disabledModulesDir; // (string) Disabled Modules directory
    public $disabledModules;    // (array) memory variable for getDisabledModuleList()
    public $moduleManagerMe;    // (string) Name of the Module Manager Module

    public function __construct($attogram)
    {
        $this->attogram = $attogram;
        $this->enabledModulesDir = $this->attogram->modulesDirectory;
        $this->disabledModulesDir = dirname($this->enabledModulesDir)
            .DIRECTORY_SEPARATOR.'modules_disabled';
        $this->moduleManagerMe = basename(dirname(__DIR__));
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
            return $this->disabledModules;
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
        $this->attogram->log->debug('ModuleManager::getModuleList: '
            .$directory, $this->modules);
        return $this->modules;
    }

    public function enable($module)
    {
        $result = 'ENABLING: ' . $this->attogram->webDisplay($module);
        // module is already enabled?
        if (array_key_exists($module, $this->getEnabledModuleList())) {
            return $result.'<br />ERROR: Module already enabled';
        }
        // module exists and is disabled?
        $disabled = $this->getDisabledModuleList();
        if (!array_key_exists($module, $disabled)) {
            return $result.'<br />ERROR: Module does not exist';
        }
        // rename to /modules/*
        $oldName = $disabled[$module];
        $newName = $this->enabledModulesDir.DIRECTORY_SEPARATOR.$module;
        $result .= '<br />MOVING <code>'.$oldName.'</code> to <code>'.$newName.'</code>';
        if (!$this->move($oldName, $newName)) {
            $result .= '<br />ERROR: can not move module';
        }
        $this->attogram->event->notice('ENABLED module: '
            .$this->attogram->webDisplay($module).': '.$newName);
        return $result;
    }

    public function disable($module)
    {
        $result = 'DISABLING: ' . $this->attogram->webDisplay($module);
        // may not disable the Module Manager!
        if ($module == $this->moduleManagerMe) {
            return $result.'<br />ERROR: May not disable the Module Manager!';
        }
        // module is already disabled?
        if (array_key_exists($module, $this->getDisabledModuleList())) {
            return $result.'<br />ERROR: Module already disabled';
        }
        // module exists and is enabled?
        $enabled = $this->getEnabledModuleList();
        if (!array_key_exists($module, $enabled)) {
            return $result.'<br />ERROR: Module does not exist';
        }
        // rename to /modules/*
        $oldName = $enabled[$module];
        $newName = $this->disabledModulesDir.DIRECTORY_SEPARATOR.$module;
        $result .= '<br />MOVING <code>'.$oldName.'</code> to <code>'.$newName.'</code>';
        if (!$this->move($oldName, $newName)) {
            $result .= '<br />ERROR: can not move module';
        }
        $this->attogram->event->notice('DISABLED module: '
            .$this->attogram->webDisplay($module).': '.$newName);
        return $result;
    }

    /**
     * move a module to a new location
     * @param string $oldName  path + filename of file/directory to move
     * @param string $newName  path + filename of new location for file/directory
     * @return bool
     */
    public function move($oldName, $newName)
    {
        if (!is_readable($oldName)) {
            $this->attogram->log->error('ModuleManager:moveModule: source module not found: '
                .$this->attogram->webDisplay($oldName));
            return false;
        }
        if (!is_dir($oldName)) {
            $this->attogram->log->error('ModuleManager:moveModule: source module directory not found: '
                .$this->attogram->webDisplay($oldName));
            return false;
        }
        if (file_exists($newName)) {
            $this->attogram->log->error('ModuleManager:moveModule: target module already exists: '
                .$this->attogram->webDisplay($newName));
            return false;
        }
        if (!rename($oldName, $newName)) {
            $this->attogram->log->error('ModuleManager::moveModule: move failed: '
                .$this->attogram->webDisplay($oldName).' to '
                .$this->attogram->webDisplay($newName));
            return false;
        }
        unset($this->enabledModules);
        unset($this->disabledModules);
        return true;
    }

}
