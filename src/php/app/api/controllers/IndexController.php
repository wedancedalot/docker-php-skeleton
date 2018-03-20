<?php
namespace App\Controllers;

use App\Lib\Response;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        var_dump(date('Y-m-d H:i:s', time()));
    }

    public function contactAction()
    {
    }
}