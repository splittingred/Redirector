<?php
/**
 * @package redirector
 */
$xpdo_meta_map['modRedirectPageNotFound']= array (
  'package' => 'redirector',
  'version' => NULL,
  'table' => 'pagesnotfound',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'url' => NULL,
    'times' => 0,
    'firsttime' => 0,
    'lasttime' => 0,
    'visible' => 1,
  ),
  'fieldMeta' => 
  array (
    'url' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
    ),
    'times' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'firsttime' => 
    array (
      'dbtype' => 'int',
      'precision' => '100',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'lasttime' => 
    array (
      'dbtype' => 'int',
      'precision' => '100',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'visible' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
    ),
  ),
);
