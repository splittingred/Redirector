<?php
/**
 * @package redirector
 */
$xpdo_meta_map['modRedirect']= array (
  'package' => 'redirector',
  'table' => 'redirects',
  'fields' => 
  array (
    'pattern' => '',
    'target' => '',
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'pattern' => 
    array (
      'dbtype' => 'nvarchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'unique',
    ),
    'target' => 
    array (
      'dbtype' => 'nvarchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'active' => 
    array (
      'dbtype' => 'bit',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
      'index' => 'index',
    ),
  ),
);
