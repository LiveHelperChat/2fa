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

$ViewList['manage'] = array(
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['verifycode'] = array(
    'params' => array('hash','method'),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['resend'] = array(
    'params' => array('hash','method'),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['attemptlimit'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['expired'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array()
);

$ViewList['regeneratega'] = array(
    'params' => array('user_id'),
    'uparams' => array(),
    'functions' => array('use')
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

$ViewList['sms'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('configure')
);

$ViewList['email'] = array(
    'params' => array(),
    'uparams' => array(),
    'functions' => array('configure')
);

$FunctionList['use'] = array('explain' => 'Allow operator to use 2FA module');
$FunctionList['configure'] = array('explain' => 'Allow operator to configure 2FA module');