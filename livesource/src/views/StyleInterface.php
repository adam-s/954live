<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/21/16
 * Time: 7:54 PM
 */

namespace Drupal\livesource\views;


interface StyleInterface {

    public function render($resultObject);

    public function getQuery();
}