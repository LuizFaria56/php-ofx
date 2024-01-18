<?php
require_once(__DIR__.'/Home.php');
echo 'AQUI';
//use Home;
$arquivo = '/opt/lampp/htdocs/ofx/doc/extratoBB202401.ofx';
$ofx = new Home();
$result = $ofx->index($arquivo);
