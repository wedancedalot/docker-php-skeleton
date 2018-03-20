<?php
namespace App\Models;

class ModelBase extends \Phalcon\Mvc\Model
{
    public function defaultValue()
    {
        return new \Phalcon\Db\RawValue('default');
    }
}