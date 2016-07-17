<?php
// Attogram Framework - ModuleManager class v0.0.1

namespace Attogram;

class ModuleManager
{
    public $attogram;
    public $modules;

    public function __construct($attogram)
    {
        $this->attogram = $attogram;
    }

    public function getModuleList($directory)
    {
        $this->modules = array();
        foreach (array_diff(scandir($directory), $this->attogram->getSkipFiles()) as $dir) {
            $moduleDirectory = $directory.DIRECTORY_SEPARATOR.$dir;
            if (!is_dir($moduleDirectory)) {
                continue;
            }
            if (!is_readable($moduleDirectory)) {
                continue;
            }
            $this->modules[] = $moduleDirectory;
        }
        return $this->modules;
    }
}
