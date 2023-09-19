<?php

/**
 * Auth class: Library used for universal authentication procedures.
 */
class Auth {

    /**
     * Sanitize String: Used to sanitize a string for database input.
     *
     * @param $_str
     * @return mixed
     *
     * @author Chris T.
     */
    public static function sanitizeString($_str) {
        return filter_var($_str, FILTER_SANITIZE_STRING);
    }

    /**
     * Sanitize Email: Used to sanitize an email for database input.
     *
     * @param $_email
     * @return mixed
     *
     * @author Chris T.
     */
    public static function sanitizeEmail($_email) {
        return filter_var($_email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Checks to make sure two values are equal to each other.
     *
     * @param $_value1
     * @param $_value2
     * @return bool
     *
     * @author Chris T.
     */
    public static function isEqual($_value1, $_value2) {
        return $_value1 == $_value2;
    }
}