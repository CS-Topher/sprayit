<?php

/**
 * User Model: This is a model for any given user. It handles login authentication and has custom methods related
 * to users.
 */
class User {

    /**
     * The table that this particular object belongs to within the database.
     */
    private $dataTable = 'user';

    //==================================================================================================================

    /**
     * Get User UUID: Returns the user's UUID based on his/her session ID.
     *
     * @return mixed
     *
     * @author Ioannis Batsios
     */
    public static function getUuid() {
        $userId = Session::getField('user_id');
        return DatabaseConnector::getUuid($userId);
    }

    /**
     * Get User Email: Returns the email of the passed in user.
     *
     * @author Chris T.
     */
    public function getEmail($_user) {
        return $_user->email;
    }

    //==================================================================================================================

    /**
     * Authenticate User Login: Checks the credentials that are passed in as parameters and proceeds to perform
     * the login flow.
     *
     * @author Chris T.
     */
    public static function authenticate($_email = null, $_password = null, $_errors = []) {
        $_email = Auth::sanitizeEmail($_email);
        $_password = Auth::sanitizeString($_password);

        if ($_email != '' && $_email != null && $_password != '' && $_password != null) {
            $user = DatabaseConnector::findUserByEmail($_email);
        } else {
            return false;
        }

        // If $user is not false.
        if ($user) {

            // Checks the parametrized password against the one found in the database.
            if ($_password == $user->password) {

                // Passwords matched, commence login.
                self::createUserSession($user);
                return true;
            } else {

                // Passwords did not match.
                return false;
            }
        }
        return false;
    }

    /**
     * Function registers user. Gets sanitized data from the controller, calls the Database Connector, and passes to database.
     *
     * @author Ioannis Batsios
     *
     * To Do: split if statements into their own functions so if Registrations changes, easy to change function.
     */
    public static function registerUser($_fname, $_lname, $_email, $_confirmEmail, $_password, $_confirmPassword) {
        // Checks to make sure emails match. If not, returns false
        if (self::confirmEmail($_email, $_confirmEmail) && self::checkPasswords($_password, $_confirmPassword)) {
            if (DatabaseConnector::checkDuplicateEmails($_email)) {
                //creates a unique user id
                $uuid = uniqid();
                if (DatabaseConnector::createUser($_fname, $_lname, $_email, $_password, $uuid)) {
                    //Api call
                    MailConnector::send($_email, $_fname, REGISTRATION_EMAIL_SUBJECT, REGISTRATON_EMAIL_BODY);
                    //echo "Registered! Login please";
                    return true;
                } else {
                    //echo 'Error: user not created!';
                    return false;
                }
            } else {
                //echo "Email already exists in our database.";
                return false;
            }
        }
    }

    /*
     * Function to see if emails typed match.
     * Returns false if not.
     *
     * @author Ioannis Batsios
     */
    private static function confirmEmail($_email, $_emailToConfirm) {
        if ($_email != $_emailToConfirm) {
            //echo "Emails do not match!";
            return false;
        } else {
            return true;
        }
    }

    /**
     * Function to see if passwords match.
     * Returns false if not
     *
     * @author Ioannis Batsios
     */
    private static function checkPasswords($_password, $_samePassword) {
        if ($_password != $_samePassword) {
            //echo "Passwords do not match!";
            return false;
        } else {
            return true;
        }
    }

    /**
     * A function that returns a salted hash for a password. Used to make database more secure from outside threats.
     *
     * @author Ioannis Batsios
     */
    private static function saltPassword($_password) {
        $salt = random_bytes(16);
        return $password_hash = crypt($_password, $salt);
    }

    /**
     * Create User Session: Sets the session variables to the passed in user's properties or values.
     *
     * @author Chris T.
     */
    protected static function createUserSession($_user) {
        $_SESSION['user_email'] = $_user->email;
        $_SESSION['user_fname'] = $_user->fname;
        $_SESSION['user_id'] = $_user->id;
        $_SESSION['user_uuid'] = $_user->user_uuid;
        Redirect::to(POSTS_HOME);
    }

    /**
     * Destroy User Session: Un-sets all of the session variables for the logged in user.
     *
     * @author Chris T.
     */
    public static function destroyUserSession() {
        unset($_SESSION['user_email']);
        unset($_SESSION['user_fname']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_uuid']);
        session_destroy();
        Redirect::to(LOGIN_PATH);
    }
}