<?php
// Attogram Framework - Module Manager Admin Page v0.0.3

namespace Attogram;

$manager = new ModuleManager($this);

$this->pageHeader('Module Manager');

print '<div class="container"><h1 class="squished">Module Manager</h1><hr />';

if ($this->request->query->has('e')) {
    print $manager->enable($this->request->query->get('e'));
}

if ($this->request->query->has('d')) {
    print $manager->disable($this->request->query->get('d'));
}

print '<h3>Active Modules:</h3>';
foreach ($manager->getEnabledModuleList() as $moduleName => $modulePath) {
    print '<br />ENABLED <a href="?d='.urlencode($moduleName).'">(disable)</a>'
        .' &nbsp; &nbsp; <strong>'.$moduleName.'</strong> &nbsp; &nbsp; <code>'
        .$modulePath.'</code>';
}

print '<h3>Disabled Modules:</h3>';
foreach ($manager->getDisabledModuleList() as $moduleName => $modulePath) {
    print '<br /><a href="?e='.urlencode($moduleName).'">(enable)</a> DISABLED'
        .' &nbsp; &nbsp; <strong>'.$moduleName.'</strong> &nbsp; &nbsp; <code>'
        .$modulePath.'</code>';
}

print '</p></div>';

$this->pageFooter();
