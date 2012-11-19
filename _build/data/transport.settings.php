<?php

$s = array(
    'Default' => array(
        'on_alias_update' => 'Yes',
    ),
);

$settings = array();
foreach ($s as $area => $sets) {
    foreach ($sets as $key => $value) {
        $settings['redirector.'.$key] = $modx->newObject('modSystemSetting');
        $settings['redirector.'.$key]->set('key', 'redirector.'.$key);
        $settings['redirector.'.$key]->fromArray(array(
            'value' => $value,
            'xtype' => 'textfield',
            'namespace' => 'redirector',
            'area' => $area
        ));
    }
}

return $settings;