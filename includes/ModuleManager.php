<?php
// Attogram Framework - ModuleManager class v0.0.8

namespace Attogram;

class ModuleManager
{
    public $attogram;           // (object) Attogram Framework Object
    public $enabledModulesDir;  // (string) Modules Directory
    public $enabledModules;     // (array) memory variable for getEnabledModuleList()
    public $disabledModulesDir; // (string) Disabled Modules directory
    public $disabledModules;    // (array) memory variable for getDisabledModuleList()
    public $moduleManagerMe;    // (string) Name of the Module Manager Module

    /**
     * @param object $attogram  The Attogram Framework object
     */
    public function __construct($attogram)
    {
        $this->attogram = $attogram;
        $this->enabledModulesDir = $this->attogram->modulesDirectory;
        $this->disabledModulesDir = dirname($this->enabledModulesDir)
            .DIRECTORY_SEPARATOR.'modules_disabled';
        $this->moduleManagerMe = basename(dirname(__DIR__));
    }

    /**
     * get a list of enabled modules
     * @return array  List of names of enabled modules
     */
    public function getEnabledModuleList()
    {
        if (is_array($this->enabledModules)) {
            return $this->enabledModules;
        }
        return $this->enabledModules = $this->getModuleList($this->enabledModulesDir);
    }

    /**
     * get a list of disabled modules
     * @return array  List of names of disabled modules
     */
    public function getDisabledModuleList()
    {
        if (is_array($this->disabledModules)) {
            return $this->disabledModules;
        }
        return $this->disabledModules = $this->getModuleList($this->disabledModulesDir);
    }

    /**
     * get a list of module names from within a specific directory
     * @param string $directory  The directory to search
     * @return array
     */
    private function getModuleList($directory)
    {
        $modules = array();
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
            $moduleInfo = $this->getModuleInfo($dir);
            $modules[$moduleInfo['name']]['description'] = $moduleInfo['description'];
            $modules[$moduleInfo['name']]['path'] = $moduleDirectory;
        }
        $this->attogram->log->debug(
            'ModuleManager::getModuleList: '.$directory,
            $modules
        );
        return $modules;
    }

    /**
     * enable a module
     * @param string $module  Name of the module to enable
     * @return bool
     */
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
        // rename to /modules/$module
        $oldName = $disabled[$module]['path'];
        $newName = $this->enabledModulesDir.DIRECTORY_SEPARATOR.$module;
        $result .= '<br />MOVING <code>'.$oldName.'</code> to <code>'.$newName.'</code>';
        if (!$this->move($oldName, $newName)) {
            $result .= '<br />ERROR: can not move module';
        }
        $this->attogram->event->notice('ENABLED module: '
            .$this->attogram->webDisplay($module).': '.$newName);
        return $result;
    }

    /**
     * disable a module
     * @param string $module  Name of the module to disable
     * @return bool
     */
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
        // rename to /modules_disabled/$module
        $oldName = $enabled[$module]['path'];
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
     * @param string $oldName  path + filename of module directory to move
     * @param string $newName  path + filename of new location for module directory
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

    /**
     * get module name and description from composer.json file
     * @param string $moduleDir  The Module directory to search
     * @return array
     */
    public function getModuleInfo($moduleDir)
    {
        $result['name'] = $moduleDir;
        $result['description'] = '?';
        return $result;
    }
}
