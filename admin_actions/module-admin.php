<?php
// Attogram Framework - Module Manager Admin Page v0.0.8

namespace Attogram;

$manager = new ModuleManager($this);

$this->pageHeader('Module Manager');

print '<div class="container">'
    .'<h1 class="squished">Module Manager</h1>'
    .'<hr />';

if ($this->request->query->has('e')) {
    print $manager->enable($this->request->query->get('e'));
}

if ($this->request->query->has('d')) {
    print $manager->disable($this->request->query->get('d'));
}

print '<h3>Active Modules:</h3>';
foreach ($manager->getEnabledModuleList() as $moduleBaseName => $moduleInfo) {
    print '<br />ENABLED <a href="?d='.urlencode($moduleBaseName).'">(disable)</a>'
    .' &nbsp; &nbsp; <strong>'.$moduleInfo['name'].'</strong> &nbsp; - <small>'
    .$moduleInfo['description'] . '</small>';
}

print '<h3>Disabled Modules:</h3>';
foreach ($manager->getDisabledModuleList() as $moduleBaseName => $moduleInfo) {
    print '<br /><a href="?e='.urlencode($moduleBaseName).'">(enable)</a> DISABLED'
    .' &nbsp; &nbsp; <strong>'.$moduleInfo['name'].'</strong> &nbsp; - <small>'
    .$moduleInfo['description'] . '</small>';
}

print '</div>';

$this->pageFooter();
