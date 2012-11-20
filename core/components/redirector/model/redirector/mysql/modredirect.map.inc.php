<?php
/**
 * @package redirector
 */
$xpdo_meta_map['modRedirect']= array (
  'package' => 'redirector',
  'version' => NULL,
  'table' => 'redirects',
  'extends' => 'xPDOSimpleObject',
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
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'unique',
    ),
    'target' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
      'index' => 'index',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
      'index' => 'index',
    ),
  ),
);
