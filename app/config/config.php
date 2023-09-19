<?php

// MYSQLTRANSLATOR PARAMETERS ==========================================================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sprayit');

//======================================================================================================================

// TRUE FALSE ==========================================================================================================

define('TRUE', 1);
define('FALSE', 0);

//======================================================================================================================

// APPLICATION DIRECTORY INFORMATION ===================================================================================

// App Root
define('APP_ROOT', dirname(dirname(__FILE__)));

// URL Root
define('URL_ROOT', 'http://localhost/sprayit');

// DB Translator Name
define('DB_TRANSLATOR', 'MySqlTranslator');

// Site Name
define('SITE_NAME', 'SprayIt');

// Site Motto
define('MOTTO', 'We don\'t moderate like those panzies <br/><span class="pink"> Facebook </span>and <span class="pink">Twitter</span>!<br/> <span class="red">SPRAY</span> whatever you <span class="green">WANT!</span>');

// CONSTANT PATHS BELOW (for easy refactor / link changes)

define('POSTS_EDIT', 'posts/edit');

define('POSTS_EDITED', 'posts/edited');

define('POSTS_HOME', 'posts/index');

define('POSTS_SHOW', 'posts/show');

define('POSTS_ADD', 'posts/add');

define('POSTS_DELETE', 'posts/delete');

define('POSTS_DELETE_SUCCESS', 'posts/delete_success');

define('POSTS_DELETE_ERROR', 'posts/delete_error');

define('LOGIN_PATH', 'users/login');

define('LOGOUT_PATH', 'users/logout');

define('REGISTER_PATH', 'users/register');

define('NOT_FOUND_PATH', 'pages/not_found');

define('UPDATE_USER', 'users/update');

define('ERROR_PATH', 'users/error');

define('TEST_PATH', 'tests/authenticate');

//======================================================================================================================

// MAIL API CONFIG =====================================================================================================

define('MAIL_TRANSLATOR', 'SendGridTranslator');

define('SENDGRID_KEY', '');

define('NOREPLY_ADDRESS', 'noreply@sprayit.com');

define('NOREPLY_NAME', 'noreply');

define('REGISTRATION_EMAIL_SUBJECT', 'Welcome to SprayIt!');

define('REGISTRATON_EMAIL_BODY', 'Thank you for signing up for SprayIt. Your account has been verified and saved! You can now log in.');

//======================================================================================================================
