<?php
// Attogram Framework - Module Manager Admin Page v0.2.0

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
    print moduleRow($moduleBaseName, $moduleInfo, true);
}

print '<h3>Disabled Modules:</h3>';
foreach ($manager->getDisabledModuleList() as $moduleBaseName => $moduleInfo) {
    print moduleRow($moduleBaseName, $moduleInfo, false);
}

print '</div>';
$this->pageFooter();

/**
 * display a pretty bootstrapy row of module information
 * @param string $moduleBaseName  Base path+file of module
 * @param array $moduleInfo  Array of module information from composer.json
 * @param bool $enabled  True if module currently is enabled, false if disabled
 * @return string  HTML fragment
 */
function moduleRow($moduleBaseName, $moduleInfo, $enabled = true)
{
    $homepage = (
        isset($moduleInfo['homepage'])
        ? '<br /><a href="'.$moduleInfo['homepage'].'">'.$moduleInfo['homepage'].'</a>'
        : ''
    );
    $license = (
        isset($moduleInfo['license'])
        ? '<br />License: '.$moduleInfo['license']
        : ''
    );
    $backgroundColor = (
        $enabled
        ? '#d9ffcc'
        : '#ffdddd'
    );
    $showEnableDisable = true;
    if ($moduleInfo['name'] == ModuleManager::MODULE_MANAGER_NAME ) {
        $backgroundColor = 'lightyellow';
        $showEnableDisable = false;
    }
    $frag = '<div class="row"'
        .' style="border:1px solid grey;padding:2px;background-color:'
        .$backgroundColor.';">'
        .'<div class="col-sm-4"><strong>'.$moduleInfo['name'].'</strong></div>'
        .'<div class="col-sm-5"><small>'.$moduleInfo['description']
        .$license
        .$homepage
        .'</small></div>';
    if ($enabled && $showEnableDisable) {
        $frag .= '<div class="col-sm-3">ENABLED <a href="?d='
              .urlencode($moduleBaseName).'">(disable)</a></div>';
    }
    if (!$enabled && $showEnableDisable) {
        $frag .= '<div class="col-sm-3"><a href="?e='
            .urlencode($moduleBaseName).'">(enable)</a> DISABLED</div>';
    }
    $frag .= '</div>';
    return $frag;
}
