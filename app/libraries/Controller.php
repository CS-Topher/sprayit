<?php

/**
 * Base Controller: The parent controller to all subsequent controllers which allows each child to load models
 * and render views.
 */
class Controller {

    /**
     * Model function: Allows a controller to load a model and send data to it.
     *
     * @param $_model
     * @return mixed
     *
     * @author Chris T., Ioannis Batsios
     */
    protected function model($_model) {
        // Require model file
        require_once '../app/models/' . $_model . '.php';

        // Instantiate the model
        return new $_model();
    }

    /**
     * View function: Allows a controller to render a view by passing any data into it.
     *
     * @author Chris T., Ioannis Batsios
     */
    protected function view($_view, $_data = []) {
        // Check for view file
        if (file_exists('../app/views/' . $_view . '.php')) {
            require_once '../app/views/' . $_view . '.php';
        } else {

            // View does not exist
            Redirect::to(NOT_FOUND_PATH);
        }
    }
}
