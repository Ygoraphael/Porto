<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function isDate($value) {
    if (!$value) {
        return false;
    }

    try {
        new \DateTime($value);
        return true;
    } catch (\Exception $e) {
        return false;
    }
}