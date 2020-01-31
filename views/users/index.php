<?php
require_once("../../controllers/includes.php");

$title = "My Profile";

require_once("../elements/header.php");
require_once("../elements/nav.php");


// Check if the id is set
// if it is, get the user by id and pass data
// else load current user
if( !empty($_GET['id'])) {
    $user_id = $_GET['id'];
    $u_model = new User;
    $selected_user = $u_model->get_by_id($user_id);
} else {
    $selected_user = $current_user;
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <img src="<?=$selected_user['profile_pic']?>" class="w-25">
            <h2>My Profile</h2>
            <p><?=$selected_user['firstname']. " ". $selected_user['lastname'];?></p>
            <p><?=$selected_user['bio']?></p>
            <?php
            if($selected_user['id'] == $_SESSION['user_logged_in']) {
                ?>
                <p>
                    <a href="/users/edit.php" class="btn btn-primary">Edit Profile</a>
                </p>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="row">
        <?php
        // get all projects by this user
        $p_model = new Project;
        $user_projects = $p_model->get_by_user_id($selected_user['id']);
        foreach($user_projects as $user_project) {

            ?>

            <div class="some_image">
                <img src="<?=$user_project['file_url'] ?>">
            </div>
            <?php 

        }
        ?>
    </div>
</div>

<?php
require_once("../elements/footer.php");
?>