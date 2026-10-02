<?php
/**
 * Created by PhpStorm.
 * User: TD-PLUS
 * Date: 11/13/2018
 * Time: 12:14 PM
 */

namespace App\Interfaces;


interface CookieBaseModels
{
    public function get();

    public  function make();

    public function details();

    public function has($object);

    public function add($object);

    public function remove($object);

    public function count();
}
