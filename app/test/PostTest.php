<?php

// Must manually add these requires, as the command line does not automatically load everything through SprayItCore.
require_once '../models/Post.php';
require_once '../libraries/Auth.php';

/**
* Post Test: This class is used for testing methods within the Post model.
*/
class PostTest {

    /**
     * Method used to begin tests on the selected method(s).
     *
     * @author Chris T.
     */
    public static function systemTest() {
        // Normal test cases below.
        echo("Testing normal case 01.\n");
        echo((self::testCheckFields("Title 1", "This is the body!", true)) ? "Pass\n\n" : "Fail\n\n");

        echo("Testing normal case 02.\n");
        echo((self::testCheckFields("Título 2", "¡Este es el cuerpo!", true)) ? "Pass\n\n" : "Fail\n\n");

        echo("Testing normal case 03.\n");
        echo((self::testCheckFields("タイトル 3", "これが体です！", true)) ? "Pass\n\n" : "Fail\n\n");

        // Edge test cases below.
        echo("Testing edge case 01.\n");
        echo((self::testCheckFields("", "This is the body!", false)) ? "Pass\n\n" : "Fail\n\n");

        echo("Testing edge case 02.\n");
        echo((self::testCheckFields("Title 2", "", false)) ? "Pass\n\n" : "Fail\n\n");

        echo("Testing edge case 03.\n");
        echo((self::testCheckFields("", "", false)) ? "Pass\n\n" : "Fail\n\n");

        // Error test cases below.
        echo("Testing error case 01.\n");
        echo((self::testCheckFields("Title 1", null, false)) ? "Pass\n\n" : "Fail\n\n");

        echo("Testing error case 02.\n");
        echo((self::testCheckFields(null, "Body stuff here", false)) ? "Pass\n\n" : "Fail\n\n");

        echo("Testing error case 03.\n");
        echo((self::testCheckFields("<script>alert('YOU BEEN HACKED BOI')</script>", "TRUNCATE TABLE `posts`", true)) ? "Pass\n\n" : "Fail\n\n");
    }

    /**
     * Method used to test the checkFields() method in the Post model.
     *
     * @param $_title
     * @param $_body
     * @param $_expected
     * @return bool
     *
     * @author Chris T.
     */
    public static function testCheckFields($_title, $_body, $_expected) {
        $result = Post::checkFields($_title, $_body);

        if ($result === $_expected) {
            return true;
        } else {
            return false;
        }
    }
}
