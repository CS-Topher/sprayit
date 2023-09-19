<?php

/**
 * Redirect class: This is a helper class used to make redirecting to other pages much easier than continuously typing the
 * header function.
 */
class Redirect {

    /**
     * To method: Performs the action of redirecting "to" a specified page.
     *
     * @author Chris T.
     */
    public static function to($_page = null) {
        if ($_page != null && $_page != '') {
            header('location: ' . URL_ROOT . '/' . $_page);
        } else {
            header('location: ' . URL_ROOT . '/' . NOT_FOUND_PATH);
        }
    }
}