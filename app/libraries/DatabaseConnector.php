<?php

/**
 * Database Connector class: Connects to the database translator which is specified in the config file.
 */
class DatabaseConnector
{

    /**
     * The translator class's name (defined in config/config.php).
     */
    private static $translator = DB_TRANSLATOR;

    //==================================================================================================================

    /**
     * Returns all records from a specified table.
     *
     * @author Chris T.
     */
    public static function getAll($_table)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::getAll($_table);
    }

    /**
     * A function that returns all posts.
     *
     * @return mixed
     *
     * @author Chris T.
     */
    public static function getAllPosts()
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::getAllPosts();
    }

    /**
     * A function that gets a post by the post's uuid.
     *
     * @param $_postUuid
     * @return mixed
     *
     * @author Ioannis Batsios
     */
    public static function getPostByPostUuid($_postUuid)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::getPostByPostUuid($_postUuid);
    }

    /**
     * A function that gets a user uuid.
     *
     * @param $_userId
     * @return mixed
     *
     * @author Ioannis Batsios
     */
    public static function getUuid($_userId)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::getUuid($_userId);
    }

    /**
     * Passes the email value to the specified database translator's findUserByEmail method.
     *
     * @author Chris T.
     */
    public static function findUserByEmail($_email)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::findUserByEmail($_email);
    }

    //==================================================================================================================

    /**
     * Checks to make sure User isn't adding same email to the database.
     *
     * @author Ioannis Batsios
     */
    public static function checkDuplicateEmails($_email)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::checkDuplicateEmails($_email);
    }

    /**
     * Calls the database translator to pass the user's credentials to be added to the database.
     *
     * @param $_fname
     * @param $_lname
     * @param $_email
     * @param $_password
     * @param $_uuid
     * @return mixed
     *
     * @author Chris T.
     */
    public static function createUser($_fname, $_lname, $_email, $_password, $_uuid)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::createUser($_fname, $_lname, $_email, $_password, $_uuid);
    }

    /**
     * Calls the database translator to pass the post information to be added to the database.
     *
     * @param $_title
     * @param $_body
     * @param $_userUuid
     * @param $_postUuid
     * @return mixed
     *
     * @author Chris T.
     */
    public static function createPost($_title, $_body, $_userUuid, $_postUuid)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::createPost($_title, $_body, $_userUuid, $_postUuid);
    }

    /**
     * Calls the database translator to pass the updated post information to be edited within the database.
     *
     * @param $_postUuid
     * @param $_title
     * @param $_body
     * @return mixed
     *
     * @author Ioannis Batsios
     */
    public static function editPost($_postUuid, $_title, $_body)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::editPost($_postUuid, $_title, $_body);
    }

    /**
     * Calls the database translator to pass the post's uuid so that the post can be "deleted" from the database (simply
     * sets the active flag to 'false').
     *
     * @param $_postUuid
     * @return mixed
     *
     * @author Chris T.
     */
    public static function deletePost($_postUuid)
    {
        $dbTranslator = static::$translator;
        return $dbTranslator::deletePost($_postUuid);
    }
}
