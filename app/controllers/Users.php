<?php

require_once APP_ROOT . '/models/User.php';

/**
 * Users controller: This controller is used to handle all data transfers for any view within the 'users' directory.
 * Each method corresponds to a view (names must be EXACTLY the same).
 */
class Users extends Controller {

    /**
     * Index: THIS METHOD IS REQUIRED. It helps prevent access to the application directory index and is the
     * default method that is called when no method is specified in the URL. For example, without this method, if
     * someone typed "localhost/sprayit/users" into the browser, without a method, THE PROGRAM WOULD CRASH because
     * an index method would not be found. Use this method to redirect to another page.
     *
     * @author Chris T.
     */
    public function index() {
        Redirect::to(LOGIN_PATH);
    }

    /**
     * Login: Transfers login form data from the login view to the User model to be handled. First checks if the user
     * logged in, redirecting them to the calendar page if so.
     *
     * @author Chris T.
     */
    public function login() {
        if (Session::isLoggedIn()) {
            Redirect::to(POSTS_HOME);
        }
        if (Session::isPost()) {
            $post = Session::sanitizePost();
            $data = [
                'email' => trim($post['email']),
                'password' => trim($post['password'])
            ];
            if (User::authenticate($post['email'], $post['password'])) {
                Redirect::to(POSTS_HOME);
            }
            $this->view(LOGIN_PATH, $data);
        }
        $this->view(LOGIN_PATH);
    }

    /**
     * Register: This registers new users. It transfers the form data to the User model to sanitize and add to the
     * database. Once registered, takes them to the login page.
     *
     * @author Ioannis Batsios
     */
    public function register() {
        // If user is already logged in, this doesn't allow them to re-register unless they are logged out.
        if (Session::isLoggedIn()) {
            Redirect::to(POSTS_HOME);
        }

        // Check if Register button is clicked.
        if (Session::isPost()) {
            $post = Session::sanitizePost();

            // Passes data to the User model.
            $user = User::registerUser($post['fname'], $post['lname'], $post['email'], $post['confirm_email'], $post['password'], $post['confirm_password']);

            // If the data is returned true
            if ($user) {
                //Go to the login screen
                $this->view(LOGIN_PATH);

                // Else send back to the registration page.
            } else {
                $this->view(REGISTER_PATH);
            }
        } else {
            $this->view(REGISTER_PATH);
        }
    }

    /**
     * Log user out: Destroys the local session variable, which logs the user out.
     *
     * @author Chris T.
     */
    public static function logout() {
        User::destroyUserSession();
        Redirect::to(LOGIN_PATH);
    }
}
