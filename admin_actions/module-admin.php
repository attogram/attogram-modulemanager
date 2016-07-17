<?php
// Attogram Framework - Module Manager Admin Page v0.0.1

namespace Attogram;

$manager = new ModuleManager($this);

$this->pageHeader('Module Manager');

print '<div class="container"><h1 class="squished">Module Manager</h1><hr />';

if ($this->request->query->has('e')) {
  print '<pre>ENABLE: '.$this->webDisplay($this->request->query->get('e')).'</pre>';
}

if ($this->request->query->has('d')) {
  print '<pre>DISABLE: '.$this->webDisplay($this->request->query->get('d')).'</pre>';
}

$modulesDisabled = dirname($this->modulesDirectory).DIRECTORY_SEPARATOR.'modules_disabled';

print '<h3>Active Modules:</h3>';
$active = $manager->getModuleList($this->modulesDirectory);
foreach ($active as $module) {
    print '<br />ENABLED <a href="?d='.urlencode($module).'">(disable)</a> &nbsp; &nbsp; '.$module;
}

print '<h3>Disabled Modules:</h3>';
$disabled = $manager->getModuleList($modulesDisabled);
foreach ($disabled as $module) {
  print '<br /><a href="?e='.urlencode($module).'">(enable)</a> DISABLED</a> &nbsp; &nbsp; '.$module;

}

print '</p></div>';

$this->pageFooter();
