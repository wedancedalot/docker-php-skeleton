<?php

namespace App\Controllers;

use App\Lib\User;
use Redis;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    public function beforeExecuteRoute()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', $this->config->project->allowed_referrer);
        $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

        if ($this->request->isOptions()) {
            $this->response->setHeader('Access-Control-Allow-Headers',
                'Origin, X-CSRF-Token, X-Requested-With, X-HTTP-Method-Override, Content-Range, Content-Disposition, Content-Type, Authorization');
            $this->response->setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
            $this->response->sendHeaders();
            exit;
        }
    }
}