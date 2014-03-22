<?php
/**
 * Created by PhpStorm.
 * User: s_melukov
 * Date: 20.03.14
 * Time: 20:54
 */

spl_autoload_register(function($className)
{
    require_once __DIR__."/".str_replace('\\','/', $className).".php";
});