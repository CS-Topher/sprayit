<?php

/**
 * SprayIt Core: This is used to perform controllers and view rendering based off of what's in the URL.
 * Format: http://localhost/sprayit/{controller}/{method}/{params}
 */
class SprayItCore {

    private $currentController = 'Posts';
    private $currentMethod = 'index';
    private $params = [];

    /**
     * SprayIt Core constructor: This is the constructor for the core class, which ends up directing the rest
     * of the program.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function __construct() {

        $url = $this->getURL();

        // Looks in 'controllers' for first value.
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            // If exists, set as controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        // Requires in the specified controller.
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiates the controller class.
        $this->currentController = new $this->currentController;

        // Checks for the second part of the URL for a method.
        if (isset($url[1])) {

            // Checks to see if the specified method exists in the specified controller.
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // Gets the parameters from what's left of the URL.
        $this->params = $url ? array_values($url) : [];

        try {

            // Calls the specified method within the specified controller with any given parameters.
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } catch (Exception $e) {
            Redirect::to(NOT_FOUND_PATH);
        }
    }

    // Method to fetch URL and create array

    /**
     * Get URL: This fetches the URL, sanitizes it, then returns the prepared URL.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function getURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return false;
    }
}