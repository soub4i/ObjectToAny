<?php
namespace Soubai\ObjectToAny;

require 'vendor/autoload.php';

class ClassName 
{
var $a;
var $b;
var $c;
}

$c = new ClassName();
$c->a = 10;
$c->b = 100;
$c->c = 1000;

// exemple convesion Object to JSON
var_dump(ObjectToAny::ToJSON($c));