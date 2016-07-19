<?php
// Attogram Framework - Module Manager Admin Page v0.1.0

namespace Attogram;

$manager = new ModuleManager($this);

if ($this->request->query->has('e')) {
    $results = $manager->enable($this->request->query->get('e'));
    header('Location: .');
    exit;
}

if ($this->request->query->has('d')) {
    $results = $manager->disable($this->request->query->get('d'));
    header('Location: .');
    exit;
}

$this->pageHeader('Module Manager');

print '<div class="container">'
    .'<h1 class="squished">Module Manager</h1>'
    .'<hr />'
    .'<h3>Active Modules:</h3>';
foreach ($manager->getEnabledModuleList() as $moduleBaseName => $moduleInfo) {
    print '<div class="row" style="border:1px solid grey;padding:2px;background-color:#d9ffcc;">'
        .'<div class="col-sm-4"><strong>'.$moduleInfo['name'].'</strong></div>'
        .'<div class="col-sm-5"><small>'.$moduleInfo['description'].'</small></div>'
        .'<div class="col-sm-3">ENABLED <a href="?d='.urlencode($moduleBaseName).'">(disable)</a></div></div>';
}

print '<h3>Disabled Modules:</h3>';
foreach ($manager->getDisabledModuleList() as $moduleBaseName => $moduleInfo) {
    print '<div class="row" style="border:1px solid grey;padding:2px;background-color:#ffdddd;">'
        .'<div class="col-sm-4"><strong>'.$moduleInfo['name'].'</strong></div>'
        .'<div class="col-sm-5"><small>'.$moduleInfo['description'].'</small></div>'
        .'<div class="col-sm-3"><a href="?e='.urlencode($moduleBaseName).'">(enable)</a> DISABLED</div></div>';
}

print '</div>';
$this->pageFooter();
