<?php

/**
 * MySQL Translator: A class which connects to a MySQL database (specified in config/config.php), allowing
 * access to persistent data.
 */
class MySqlTranslator {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $_error;

    //==================================================================================================================

    /**
     * A function to get the User's uuid.
     *
     * @param $_userId
     * @return bool
     *
     * @author Chris T.
     */
    public function getUuid($_userId) {
        $db = new MySqlTranslator();
        try {
            $db->query("SELECT user_uuid FROM `user` WHERE id = '{$_userId}'");
            $results = $db->single();
            return $results->user_uuid;
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }

    /**
     * A function to read all posts within the database with the poster's information.
     * @return mixed
     *
     * @author Chris T.
     */
    public static function getAllPosts() {
        $db = new MySqlTranslator();

        try {
            $db->query('SELECT *,
                        `posts`.id as postId,
                        `user`.id as userId,
                        `posts`.created_at as postCreated
                        FROM `posts`
                        INNER JOIN `user`
                        ON posts.user_uuid = `user`.user_uuid AND posts.active_flag = ' . TRUE . '
                        ORDER BY `posts`.created_at DESC
                        ');

            $results = $db->resultSet();
            return $results;
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }


    /**
     * A function that gets a post from the database by using the posts uuid.
     *
     * @param $_postUuid
     * @return array with title,body
     *
     * @author Ioannis Batsios
     */
    public function getPostByPostUuid($_postUuid) {
        $db = new MySqlTranslator();
        try {
            $db->query("SELECT * FROM `posts` WHERE `posts`.post_uuid = '{$_postUuid}'");
            $results = $db->single();
            return $results;
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }

    /**
     * Get all records from a table: Returns all of the rows within a specified table.
     *
     * @param $_table
     * @return mixed
     *
     * @author Chris T.
     */
    public static function getAll($_table) {
        $db = new MySqlTranslator();

        $db->query("SELECT * FROM `{$_table}`");

        $results = $db->resultSet();
        return $results;
    }
    
    //==================================================================================================================

    /******************************************* STANDARD DATABASE FUNCTIONS -- SEE CRUD BELOW -- *********************/

    /**
     * MySqlTranslator constructor: Establishes the connection to the database upon instantiation using
     * config-defined credentials.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function __construct() {
        // Sets up DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Creates a PDO instance.
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $_e) {
            echo $_e->getMessage();
        }
    }

    /**
     * Bind value to parameter: Binds a given value to a given parameter based on its type so that the database can
     * safely use it. This process defaults to string if no other type can be determined. A type can be passed in to
     * automatically bind the value as that type without checking for a matching one.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function bind($_param, $_value, $_type = null) {
        if (is_null($_type)) {
            switch (true) {
                case is_int($_value):
                    $_type = PDO::PARAM_INT;
                    break;
                case is_bool($_value):
                    $_type = PDO::PARAM_BOOL;
                    break;
                case is_null($_value):
                    $_type = PDO::PARAM_NULL;
                    break;
                default:
                    $_type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($_param, $_value, $_type);
    }

    /**
     * Query SQL: Prepares the passed in SQL code for database use.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function query($_sql) {
        $this->stmt = $this->dbh->prepare($_sql);
    }

    /**
     * Execute statement: Runs the stmt property against the database.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function execute() {
        return $this->stmt->execute();
    }


    /**
     * Return set of results: Returns all results of the SQL statement.
     *
     * @return mixed
     *
     * @author Chris T., Ioannis Batsios
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Return single result: Returns a single row from the database if it matches the stmt property's query code.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Get row count: Returns the number of rows in the database that were affected by the execution of the stmt
     * property.
     *
     * @author Chris T., Ioannis Batsios
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    /****************************************** CREATE FUNCTIONS ******************************************************/

    /**
     * A function to create a new user.
     * @param $_fname
     * @param $_lname
     * @param $_email
     * @param $_password
     * @param $_uuid
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public static function createUser($_fname, $_lname, $_email, $_password, $_uuid) {
        $db = new MySqlTranslator();
        try {
            $db->query("INSERT INTO `user` 
                            (`user`.fname, `user`.lname, `user`.email, `user`.password, `user`.user_uuid) 
                            VALUES ('{$_fname}','{$_lname}','{$_email}','{$_password}', '{$_uuid}')");
            return $db->execute();
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }

    /**
     * A function to create a new post.
     *
     * @param $_title
     * @param $_body
     * @param $_userUuid
     * @param $_postUuid
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public static function createPost($_title, $_body, $_userUuid, $_postUuid) {
        $db = new MySqlTranslator();
        try {
            $db->query("INSERT INTO `posts` (`posts`.title, `posts`.body, `posts`.user_uuid, `posts`.post_uuid) 
                              VALUES ('{$_title}','{$_body}','{$_userUuid}', '{$_postUuid}')");
            return $db->execute();
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }

    /****************************************** READ FUNCTIONS ********************************************************/

    /**
     * Find a User by Email: Takes an email address parameter and tries to match it with one in the database. If
     * a match is found, it returns the corresponding row. If not, it returns false.
     *
     * @author Chris T.
     */
    public static function findUserByEmail($_email) {

        // Establishes a connection to the database.
        $db = new MySqlTranslator;

        // Sends the SQL to be prepared for database use.
        $db->query("SELECT * FROM `user` WHERE email = :email");

        // Bind the email value (expected string) to the prepared variable.
        $db->bind(':email', $_email);

        // Gets a single row for the matching email.
        $row = $db->single();

        // Checks the number of rows.
        if ($db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * A function that checks for duplicate emails. Returns false if there is.
     *
     * @param $_email
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public static function checkDuplicateEmails($_email) {
        $db = new MySqlTranslator;
        try {
            $db->query("SELECT * FROM `user` WHERE `user`.email = '{$_email}'");
            $result = $db->resultSet();
            if ($result) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }

    /****************************************** UPDATE FUNCTIONS ******************************************************/

    /**
     * A function that Updates a post. Must be post's author to do so.
     *
     * @param $_postUuid
     * @param $_title
     * @param $_body
     * @return bool
     *
     * @author Ioannis Batsios
     */
    public function editPost($_postUuid, $_title, $_body) {
        $db = new MySqlTranslator();
        try {
            $db->query("UPDATE `posts` SET `posts`.title = '{$_title}', `posts`.body = '{$_body}' 
            WHERE `posts`.post_uuid = '{$_postUuid}'");
            return $db->execute();
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }

    /****************************************** DELETE FUNCTIONS ******************************************************/

    /**
     * Function to delete a Post
     *
     * @param $_postUuid
     * @return bool
     *
     * @author Chris T.
     */
    public static function deletePost($_postUuid) {
        $db = new MySqlTranslator();
        try {
            $db->query("UPDATE `posts` SET `posts`.active_flag = " . FALSE . " 
                              WHERE `posts`.post_uuid = '{$_postUuid}'");
            return $db->execute();
        } catch (PDOException $_e) {
            echo $_e->getMessage();
            return false;
        }
    }
}
