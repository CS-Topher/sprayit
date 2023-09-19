<?php

class Post {

    private static $dataTable = 'posts';

    //==================================================================================================================

    /**
     * Returns the post's uuid based on the user's ID.
     *
     * @return string
     *
     * @author Ioannis Batsios
     */
    private static function getUuid() {
        $userId = Session::getField('user_id');
        return DatabaseConnector::getUuid($userId);
    }

    /**
     * Returns all posts within the database.
     *
     * @return array
     *
     * @author Chris T.
     */
    public static function getPosts() {
        return DatabaseConnector::getAllPosts();
    }

    /**
     * Returns a post from the database based on its uuid.
     *
     * @param $_postUuid
     * @return object
     *
     * @author Ioannis Batsios
     */
    public static function getPostByPostUuid($_postUuid) {
        return DatabaseConnector::getPostByPostUuid($_postUuid);
    }

    //==================================================================================================================

    /**
     * A function that creates a new post.
     *
     * @param $_title
     * @param $_body
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public static function createPost($_title, $_body) {
        $_userUuid = Post::getUuid();
        $_postUuid = uniqid();
        if (self::checkFields($_title, $_body)) {
            if (DatabaseConnector::createPost($_title, $_body, $_userUuid, $_postUuid)) {
                return true;
            } else {
                //echo "post not created.";
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Edits an existing post by replacing its existing values (title and body) with the parameters passed in.
     *
     * @param $_postUuid
     * @param $_title
     * @param $_body
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public static function editPost($_postUuid, $_title, $_body) {
        if (self::checkFields($_title, $_body)) {
            if (DatabaseConnector::editPost($_postUuid, $_title, $_body)) {
                return true;
            } else {
                //echo "post not updated";
                return false;
            }
        }
    }

    /**
     * "Deletes" a post based on the given uuid.
     *
     * @param $_postUuid
     * @return mixed
     *
     * @author Chris T.
     */
    public static function deletePost($_postUuid) {
        try {
            return DatabaseConnector::deletePost($_postUuid);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * A function that checks to make sure the title and body are not empty.
     *
     * @param $_title
     * @param $_body
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public static function checkFields($_title, $_body) {
        $_title = Auth::sanitizeString($_title);
        $_body = Auth::sanitizeString($_body);

        if ($_title == "" || $_title == null) {
            //echo "There must be a title";
            return false;
        } else {
            if ($_body == "" || $_body == null) {
                //echo "There must be a body";
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * Utility method for posts that checks if the logged in user is the author of the post.
     *
     * @param $_postUuid
     * @return bool
     *
     * @author Chris T.
     */
    public static function verifyAuthor($_postUuid) {
        if (Session::fieldIsSet('user_uuid')) {

            $userUuid = Session::getField('user_uuid');
            $post = Post::getPostByPostUuid($_postUuid);
            $postUserUuid = $post->user_uuid;

            if (Auth::isEqual($postUserUuid, $userUuid)) {
                // Verified that the logged in user is the author of the post.
                return true;
            } else {
                // Logged in user is not the author of the post.
                return false;
            }
        } else {
            // User is not logged in.
            return false;
        }
    }
}

