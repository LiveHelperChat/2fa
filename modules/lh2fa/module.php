<?php

$Module = array( "name" => "2FA",
				 'variable_params' => true );

$ViewList = array();

$ViewList['index'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('configure')
);

$ViewList['authentication'] = array(
    'params' => array('hash'),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['verifyga'] = array(
    'params' => array('hash'),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['loginbyhash'] = array(
    'params' => array('hash'),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['googleauthentificator'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('configure')
);

$FunctionList['use'] = array('explain' => 'Allow operator to use 2FA module');
$FunctionList['configure'] = array('explain' => 'Allow operator to configure 2FA module');