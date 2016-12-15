<?php
namespace phplib;

use phplib\Lib;
include "Lib.php";

$nonceStr = Lib::createNonceStr();
echo $nonceStr;
