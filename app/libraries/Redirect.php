<?php

class Redirect {
    public static function to($_page = null) {
        if($_page) {
            header('location: ' . URL_ROOT . '/' . $_page);
        } else {
            header('location: ' . URL_ROOT . '/pages/not_found');
        }
    }

}