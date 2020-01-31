<?php
require_once("../controllers/includes.php");

$title = "Home Page";

require_once("elements/header.php");
require_once("elements/nav.php");
?>

<div class="container">
    <?php
    // if the 'user_logged_in' session variable is not set with a user ID
    if( empty($_SESSION['user_logged_in']) ) {
        // Show the login form
        require_once("elements/sign-up-form.php");
    } else {
        ?>
        <h1>Welcome to <?=APP_NAME?></h1>

        <button id="drill04" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Click This to Open Modal</button>
        <?php
        // Check for Alerts


        if( !empty($_SESSION['errors']) && is_array($_SESSION['errors'])) {
            foreach( $_SESSION['errors'] as $error ) {
                echo "<div class='alert alert-danger'>$error</div>";
            }

            unset($_SESSION['errors']);
        }

        ?>


        <div class="row">
            <div class="col-md-8">
                <div class="card mt-4" id="shareProjectCard">
                    <div class="card-header">
                        <h4>Share New Project</h4>
                    </div>
                    <div class="card-body">
                        <form action="/projects/add.php" method="post" enctype="multipart/form-data">
                            <img id="img-preview" class="w-100">
                            <div class="form-group custom-file">
                                <input class="custom-file-input" id="file-with-preview" type="file" name="fileToUpload"  required>
                                <label class="custom-file-label">Upload</label>
                            </div>
                            <div class="form-group mt-3">
                                <input class="form-control" type="text" name="title" placeholder="Project Title" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="description" placeholder="Project Description" required></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Post Project</button>
                            </div>
                        </form>
                    </div>
                </div><!--end shareProjectCard-->


                <div id="projectFeed">
                    <?php

                    $p_model = new Project;
                    $projects = $p_model->get_all();
                    $c_model = new Comment; // Get an instance of the Comment Model

                    foreach($projects as $project){
                        ?>
                        <div class="card project-post mt-3">
                            <div class="card-header">
                                <h4><a href="/users?id=<?=$project['user_id']?>"><?=$project['firstname']." ".$project["lastname"]?></a>
                                <?php
                                if($project['user_id'] == $_SESSION['user_logged_in']) {
                                    ?>
                                    <span class="float-right">
                                        <a href="/projects/edit.php?id=<?=$project['id']?>"><i class="fas fa-edit"></i></a>
                                        <a href="/projects/delete.php?id=<?=$project['id']?>"><i class="fas fa-trash-alt text-danger"></i></a>
                                    </span>
                                    <?php   
                                }
                                ?></h4>
                            </div>
                            <div class="card-img">
                                <img src="<?=$project['file_url']?>" class="img-fluid w-100">
                            </div>
                            <div class="card-body">
                                <h5><?=$project['title']?></h5>
                                <p><?=$project['description']?></p>
                                <p><small class="text-muted">Posted <?=date("M d, Y", strtotime($project['date_uploaded']))?></small></p>
                            </div>
                            <div class="card-footer">
                                <?php
                                $love_class = 'far';
                                if(!empty($project['love_id'])) {
                                    $love_class = 'fas';
                                }
                                ?>
                                <div class="project-meta">
                                    <span class="love-btn float-left" data-project="<?=$project['id']?>">
                                        <i class="<?=$love_class?> fa-heart text-danger love-icon"></i>
                                        <span class="love-count"><?=$project['love_count']?></span>
                                    </span>

                                    <span class="float-right comment-btn">
                                        <i class="far fa-comment"></i>
                                        <span class="comment-count"><?php
                                            echo $c_model->get_count($project['id']);
                                        ?></span>
                                    </span>
                                </div>

                                <div class="comment-loop pt-4">
                                   <?php
                                   $project_comments = $c_model->get_all_by_project_id($project['id']);
                                   foreach($project_comments as $user_comment) {
                                       $my_comment = ($user_comment['user_owns'] == "true") ? "my_comment" : "";
                                        ?>
                                        <div class="user-comment <?=$my_comment?>"><p>
                                        <span class="font-weight-bold comment-username"><?=$user_comment['username']?>:</span> 
                                        <?=$user_comment['comment']?>
                                        </p></div>
                                        <?php
                                    }
                                    ?>

                                </div><!-- end comment-loop -->
                                <form class="comment-form" data-project="<?=$project['id']?>">
                                    <input type="text" name="comment" placeholder="Write a comment..." class="form-control comment-box">
                                </form>
                            </div>
                        </div>
                        <?php
                    }

                    ?>
                </div>

            </div>
            <div class="col-md-4" id="searchArea">
            
            </div>
        </div>

        <?php
    }
    ?>
</div>

<div class="modal" tabindex="-1" id="exampleModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
require_once("elements/footer.php");
?>