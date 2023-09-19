<?php

/**
 * Session class: This is a helper class used to manage session-related operations.
 */
class Session {

    //==================================================================================================================

    /**
     * Returns the specified field in the session if found, false if otherwise.
     *
     * @author Chris T.
     */
    public static function getField($_field) {
        if (self::fieldIsSet($_field)) {
            return ($_SESSION["{$_field}"]);
        }
        return false;
    }

    //==================================================================================================================

    /**
     * Returns true if a given field within the $_SESSION array is set, false otherwise.
     *
     * @author Chris T.
     */
    public static function fieldIsSet($_field) {
        return (isset($_SESSION["{$_field}"]));
    }

    /**
     * If the request method is POST: Returns true if the server's request method is 'POST', false if not.
     *
     * @author Chris T.
     */
    public static function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * Sanitize POST: Returns a sanitized version of the $_POST associative array without overriding it.
     *
     * @author Chris T.
     */
    public static function sanitizePost() {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    /**
     * Check if User is Logged In: Checks if a a user is logged in; returns true if they are, false if not.
     *
     * @author Chris T.
     */
    public static function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}