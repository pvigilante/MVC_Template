<?php
require_once("../../controllers/includes.php");

// If the form was submitted
if( !empty($_POST) ){
    $user->edit();
    header("Location: /users/");
    exit;
}



$title = "Editing ".$current_user['username'];
require_once("../elements/header.php");
require_once("../elements/nav.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <h2>Edit Profile</h2>
            
            <form method="post" enctype="multipart/form-data">
                <img id="img-preview" class="w-100" src="<?=$current_user['profile_pic']?>">
                <div class="form-group custom-file">
                    <input class="custom-file-input" id="file-with-preview" type="file" name="fileToUpload">
                    <label class="custom-file-label">Upload</label>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" class="form-control" value="<?=$current_user['username']?>" required>
                </div>
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input id="firstname" type="text" name="firstname" class="form-control" value="<?=$current_user['firstname']?>" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input id="lastname" type="text" name="lastname" class="form-control" value="<?=$current_user['lastname']?>" required>
                </div>
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea id="bio" name="bio" class="form-control"><?=$current_user['bio']?></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php
require_once("../elements/footer.php");
?>