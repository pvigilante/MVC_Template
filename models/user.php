<?php
// Defined the Class of User
class User extends DB {

    /*
     *  get_all()
     *  Get all users data from the database
     * @returns array
     */
    public function get_all(){

        if( !empty($_GET['search']) ) {
            $search_query = $this->params['search'];
            $search_query = str_replace('@', '', $search_query);
            $sql_where = "WHERE users.username LIKE '%$search_query%' 
                             OR users.firstname LIKE '%$search_query%'
                             OR users.lastname LIKE '%$search_query%' ";
        } else {
            $sql_where = '';
        }

        $sql = "SELECT * FROM users $sql_where";
        $user_results = $this->select($sql);

        foreach($user_results as $key => $user) {
            $user_results[$key]['title'] = $user['firstname'] . " ".$user['lastname'];
        }

        return $user_results;

    }

    /*
     *  get_by_id()
     *  Get a users data from the database by ID
     * @params $user_id
     * @returns array
     */
    public function get_by_id($user_id) {
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $user = $this->select($sql)[0];

        return $user;
    }

    /*
     *  exists()
     *  Checks if the user already exists in the database
     * 
     * @returns array
     */
    public function exists() {
        if(APP_DEBUG) echo 'exists()<br>';
        // Check the database to see if the user exists
        $username = $this->data["username"];
        $email = $this->data["email"];

        $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";

        $user = $this->select($sql);

        return $user;

    }

    /*
     *  add()
     *  Adds the new user to the database
     * 
     * @returns int
     */
    public function add() {
        if(APP_DEBUG) echo 'add()<br>';
        $username = $this->data['username'];
        $email = $this->data['email'];
        $firstname = $this->data['firstname'];
        $lastname = $this->data['lastname'];
        $bio = $this->data['bio'];
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

        $sql = "INSERT INTO 
                    users (username, email, firstname, lastname, bio, password) 
                   VALUES ('$username', '$email', '$firstname', '$lastname', '$bio', '$password')";
        
        $new_user_id = $this->execute_return_id($sql);

        return $new_user_id;

    }

    /*
     *  edit()
     *  Edit the current user
     * 
     * @returns null
     */
    public function edit() {
        $id = (int)$_SESSION['user_logged_in']; 
        $username = $this->data['username'];
        $firstname = $this->data['firstname'];
        $lastname = $this->data['lastname'];
        $bio = $this->data['bio'];

        if( !empty($_FILES['fileToUpload']['name']) ) { // Check if new file was submitted

            $util = new Util;
            $file_upload = $util->file_upload(); // Upload the new file
            $filename = $file_upload['filename'];

            if( $file_upload['file_upload_error_status'] == 0) {
                // Get the old image
                $old_profile_image =  $this->get_by_id($id)['profile_pic'];

                $sql = "UPDATE users SET profile_pic = '$filename' WHERE id = $id";


                $this->execute($sql);

                // Delete the old image
                if( !empty($old_profile_image) ) {
                    if( file_exists(APP_ROOT. "/views" . $old_profile_image) ){
                        unlink(APP_ROOT. "/views" . $old_profile_image);
                    }
                }

            }

        }

        $sql = "UPDATE users
                SET username = '$username',
                    firstname = '$firstname',
                    lastname = '$lastname',
                    bio = '$bio' 
                WHERE id = $id";

        $this->execute($sql);
    }

    /*
     *  login()
     *  Logs in the user
     * 
     * @returns null
     */
    public function login() {

        $_SESSION = array(); // empty the session first to start fresh

        $username = $this->data['username'];
        $sql = "SELECT * FROM users WHERE username = '$username' OR email = '$username' LIMIT 1";

        $user = $this->select($sql)[0];

        if( password_verify( trim($_POST['password']), $user['password'] ) ) {
            $_SESSION['user_logged_in'] = $user['id'];
            
            // If Rememeber is set, set the cookie of user_logged_in
            if( !empty($_POST['remember'])){
                setcookie('user_logged_in', $user['id'], time() + (2 * 24 * 60 * 60), "/");
            }
        } else {
            $_SESSION['login_attempt_msg'] = "<p class='text-danger'>Incorrect username or password</p>";
        }
    }
}
?>