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
    'sortorder' => 0,
    'isregexp' => 0,
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
    'sortorder' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'isregexp' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 0,
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
