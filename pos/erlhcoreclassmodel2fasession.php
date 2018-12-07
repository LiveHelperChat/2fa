<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_2fa_session";
$def->class = "erLhcoreClassModel2FASession";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['user_id'] = new ezcPersistentObjectProperty();
$def->properties['user_id']->columnName   = 'user_id';
$def->properties['user_id']->propertyName = 'user_id';
$def->properties['user_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['ctime'] = new ezcPersistentObjectProperty();
$def->properties['ctime']->columnName   = 'ctime';
$def->properties['ctime']->propertyName = 'ctime';
$def->properties['ctime']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['valid'] = new ezcPersistentObjectProperty();
$def->properties['valid']->columnName   = 'valid';
$def->properties['valid']->propertyName = 'valid';
$def->properties['valid']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['retries'] = new ezcPersistentObjectProperty();
$def->properties['retries']->columnName   = 'retries';
$def->properties['retries']->propertyName = 'retries';
$def->properties['retries']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['remember'] = new ezcPersistentObjectProperty();
$def->properties['remember']->columnName   = 'remember';
$def->properties['remember']->propertyName = 'remember';
$def->properties['remember']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['hash'] = new ezcPersistentObjectProperty();
$def->properties['hash']->columnName   = 'hash';
$def->properties['hash']->propertyName = 'hash';
$def->properties['hash']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>