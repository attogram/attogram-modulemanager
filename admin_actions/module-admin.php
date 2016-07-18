<?php
// Attogram Framework - Module Manager Admin Page v0.0.5

namespace Attogram;

$manager = new ModuleManager($this);

$this->pageHeader('Module Manager');

print '<div class="container">'
    .'<h1 class="squished">Module Manager</h1>'
    .'<h5>Module Manager: <code>'.$manager->moduleManagerMe.'</code></h5>'
    .'<hr />';

if ($this->request->query->has('e')) {
    print $manager->enable($this->request->query->get('e'));
}

if ($this->request->query->has('d')) {
    print $manager->disable($this->request->query->get('d'));
}

print '<h3>Active Modules:</h3>';
foreach ($manager->getEnabledModuleList() as $moduleName => $moduleInfo) {
    print '<br />ENABLED <a href="?d='.urlencode($moduleName).'">(disable)</a>'
        .' &nbsp; &nbsp; <strong>'.$moduleName.'</strong> &nbsp; &nbsp; <code>'
        .$moduleInfo['path'].'</code> - '.$moduleInfo['description'];
}

print '<h3>Disabled Modules:</h3>';
foreach ($manager->getDisabledModuleList() as $moduleName => $moduleInfo) {
    print '<br /><a href="?e='.urlencode($moduleName).'">(enable)</a> DISABLED'
        .' &nbsp; &nbsp; <strong>'.$moduleName.'</strong> &nbsp; &nbsp; <code>'
        .$moduleInfo['path'].'</code> - '.$moduleInfo['description'];
}

print '</p></div>';

$this->pageFooter();
