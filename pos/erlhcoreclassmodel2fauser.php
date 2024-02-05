<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_2fa_user";
$def->class = "erLhcoreClassModel2FAUser";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['user_id'] = new ezcPersistentObjectProperty();
$def->properties['user_id']->columnName   = 'user_id';
$def->properties['user_id']->propertyName = 'user_id';
$def->properties['user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['enabled'] = new ezcPersistentObjectProperty();
$def->properties['enabled']->columnName   = 'enabled';
$def->properties['enabled']->propertyName = 'enabled';
$def->properties['enabled']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['default'] = new ezcPersistentObjectProperty();
$def->properties['default']->columnName   = 'default';
$def->properties['default']->propertyName = 'default';
$def->properties['default']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['require_by_ip'] = new ezcPersistentObjectProperty();
$def->properties['require_by_ip']->columnName   = 'require_by_ip';
$def->properties['require_by_ip']->propertyName = 'require_by_ip';
$def->properties['require_by_ip']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['is_setup'] = new ezcPersistentObjectProperty();
$def->properties['is_setup']->columnName   = 'is_setup';
$def->properties['is_setup']->propertyName = 'is_setup';
$def->properties['is_setup']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['method'] = new ezcPersistentObjectProperty();
$def->properties['method']->columnName   = 'method';
$def->properties['method']->propertyName = 'method';
$def->properties['method']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['attr'] = new ezcPersistentObjectProperty();
$def->properties['attr']->columnName   = 'attr';
$def->properties['attr']->propertyName = 'attr';
$def->properties['attr']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['lsend'] = new ezcPersistentObjectProperty();
$def->properties['lsend']->columnName   = 'lsend';
$def->properties['lsend']->propertyName = 'lsend';
$def->properties['lsend']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>