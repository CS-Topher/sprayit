<?php

require_once APP_ROOT . '/models/Post.php';

/**
 * Posts controller: This is the class that is used to control any data associated with user posts within the
 * application.
 */
class Posts extends Controller {

    /**
     * Posts constructor: Used to block unauthorized users from viewing the posts.
     *
     * @author Chris T.
     */
    public function __construct() {
        if (!Session::isLoggedIn()) {
            Redirect::to(LOGIN_PATH);
        }
    }

    /**
     * Index: THIS METHOD IS REQUIRED. It helps prevent access to the application directory index and is the
     * default method that is called when no method is specified in the URL. For example, without this method, if
     * someone typed "localhost/sprayit/posts" into the browser, without a method, THE PROGRAM WOULD CRASH because
     * an index method would not be found.
     *
     * @author Chris T.
     */
    public function index() {
        //die('In Posts/index');
        $posts = Post::getPosts();

        $data = [
            'posts' => $posts
        ];

        $this->view(POSTS_HOME, $data);
    }

    /**
     * Function to add new posts.
     *
     * @author Ioannis Batsios
     */
    public function add() {
        // Check if Register button is clicked.
        if (Session::isPost()) {
            $newPost = Session::sanitizePost();

            $newPost = Post::createPost($newPost['title'], $newPost['body']);
            //If the data is returned true.
            if ($newPost) {
                $posts = Post::getPosts();
                $data = [
                    'posts' => $posts
                ];
                $this->view(POSTS_HOME, $data);
            }
        } else {
            $this->view(NOT_FOUND_PATH);
        }
    }

    /**
     * Transfers the post to be edited to the edit page.
     *
     * @param $_postUuid
     *
     * @author Ioannis Batsios
     */
    public function edit($_postUuid) {

        // Backend check for matching user UUID.
        if (Post::verifyAuthor($_postUuid)) {
            $post = Post::getPostByPostUuid($_postUuid);

            $data = [
                'posts' => $post
            ];

            $this->view(POSTS_EDIT, $data);
        } else {
            // Credentials could not be authorized.
            Redirect::to(NOT_FOUND_PATH);
        }
    }


    /**
     * Transfers the sanitized, updated post data to the model to be updated.
     *
     * @param $_postUuid
     *
     * @author Ioannis Batsios
     */
    public function edited($_postUuid) {
        if (Session::isPost()) {
            $editedPost = Session::sanitizePost();

            // Backend check for matching user UUID.
            if (Post::verifyAuthor($_postUuid)) {
                $editedPost = Post::editPost($_postUuid, $editedPost['title'], $editedPost['body']);

                if ($editedPost) {
                    $posts = Post::getPosts();
                    $data = [
                        'posts' => $posts
                    ];
                    $this->view(POSTS_HOME, $data);
                }
            } else {
                // User UUID doesn't match post's author's UUID.
                Redirect::to(NOT_FOUND_PATH);
            }
        } else {
            // Session request is not POST.
            Redirect::to(NOT_FOUND_PATH);
        }
    }

    /**
     * Transfers the post's uuid to the model to be deleted. If an error occurs, it redirects to the delete error page.
     *
     * @param $_postUuid
     *
     * @author Chris T.
     */
    public function delete($_postUuid) {

        // Backend check for matching user UUID.
        if (Post::verifyAuthor($_postUuid)) {
            if (Post::deletePost($_postUuid)) {
                Redirect::to(POSTS_DELETE_SUCCESS);
            } else {
                // Error deleting post.
                Redirect::to(POSTS_DELETE_ERROR);
            }
        } else {
            // Error validating user credentials.
            Redirect::to(POSTS_DELETE_ERROR);
        }
    }

    /**
     * Action for the delete error page, which simply loads the view for it.
     *
     * @author Chris T.
     */
    public function delete_error() {
        $this->view(POSTS_DELETE_ERROR);
    }

    /**
     * Action for the delete success page, which simply loads the view for it.
     *
     * @author Chris T.
     */
    public function delete_success() {
        $this->view(POSTS_DELETE_SUCCESS);
    }
}