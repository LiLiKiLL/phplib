<?php
namespace phplib;

use phplib\Lib as Lib;
include "Lib.php";

$param = <<<HEREDOC
[{"position_desc": "前屏", "position": 1, "count_ry": 2, "count_mall": 2, "fee": 6000 }, {"position_desc": "首页", "position": 2, "count_ry": 2, "count_mall": 2, "fee": 6000 }, {"position_desc": "内页", "position": 3, "count_ry": 2, "count_mall": 2, "fee": 6000 }]
HEREDOC;

$param = <<<HEREDOC
{"position_desc": "前屏", "position": 1, "count_ry": 2, "count_mall": 2, "fee": 6000 }
HEREDOC;

$requiredKeys = ['position', 'count_ry', 'count_mall', 'fee'];

$result = Lib::jsonParamValidate($param, $requiredKeys, 1);

var_dump($result);