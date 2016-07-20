<?php
// Attogram Framework - Module Manager Admin Page v0.2.3

namespace Attogram;

$manager = new ModuleManager($this);

if ($this->request->query->has('e')) {
    $results = $manager->enable($this->request->query->get('e'));
    header('Location: .');
    $this->shutdown();
}

if ($this->request->query->has('d')) {
    $results = $manager->disable($this->request->query->get('d'));
    header('Location: .');
    $this->shutdown();
}

$this->pageHeader('Module Manager');

print '<div class="container">'
    .'<h1 class="squished">Module Manager</h1>'
    .'<hr />'
    .'<h3>Active Modules:</h3>';
foreach ($manager->getEnabledModuleList() as $moduleBaseName => $moduleInfo) {
    print $manager->moduleRow($moduleBaseName, $moduleInfo, true);
}

print '<h3>Disabled Modules:</h3>';
foreach ($manager->getDisabledModuleList() as $moduleBaseName => $moduleInfo) {
    print $manager->moduleRow($moduleBaseName, $moduleInfo, false);
}

print '</div>';
$this->pageFooter();
