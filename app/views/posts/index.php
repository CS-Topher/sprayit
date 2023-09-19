<!--Author: Chris T.-->
<?php require APP_ROOT . '/views/inc/header.php'; ?>
<h2><span class="blue">Water</span><span class="green">cooler</span></h2>
        <form action="<?php echo URL_ROOT . '/' . POSTS_ADD; ?>" method="post" style="padding-top: 25px;">
            <div class="row" style="margin-bottom: -40px;">
                <div class="form-group col-lg-12">
                    <input name="title" class="form-control" id="title" placeholder="Title">
                    <br>
                    <input name="body" class="form-control" id="body" placeholder="Spray It">
                </div>
            </div>
            <div class="row" style="padding-bottom: 25px;"><div class="col-lg-12"></div> </div>
            <div class="row" style="padding-bottom: 25px;"><div class="col-lg-12"></div> </div>
            <div class="row" style="padding-bottom: 25px;">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <button class="btn btn-secondary" style="width: 100%;" type="submit">Add Post</button>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </form>
<?php foreach($_data['posts'] as $post) : ?>
    <div class="row">
        <div class="card card-body mb-3">
            <div class="bg-light p-2 mb-3" style="text-align: left;">
                Written by <?php echo $post->fname; echo " " . $post->lname; ?> on <?php echo $post->postCreated; ?>
                <?php if ($post->user_uuid == Session::getField('user_uuid')) :?>
                <div class="delete" style="float: right;">
                    <div class="btn-group open">
                        <a class="btn btn-secondary" href="<?php echo URL_ROOT . '/' . POSTS_EDIT . '/' . $post->post_uuid; ?>"><i class="icon-user"><i class="far fa-edit"></i>&nbsp;&nbsp;Edit</i></a>
                        <a class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="icon-caret-down"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item"><a href="<?php echo URL_ROOT . '/' . POSTS_DELETE . '/' . $post->post_uuid; ?>"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;Delete</a></li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <h4 class="card-title"><?php echo $post->title; ?></h4>
            <p class="card-text">
                <?php echo $post->body; ?>
            </p>
<!--            <a href="--><?php //echo URL_ROOT . '/' . POSTS_SHOW . '/' . $post->postId; ?><!--" class="btn btn-dark">More</a>-->
        </div>
    </div>
<?php endforeach; ?>
<?php require APP_ROOT . '/views/inc/footer.php'; ?>