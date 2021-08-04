<?php

$req = $_POST['reqid'] . $_POST['msisdn'] . $_POST['product'] . $_POST['userid'] . '123456';
$req = strtoupper(sha1($req));
echo 'sign:'.$req;