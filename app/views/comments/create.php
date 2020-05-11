<?php
require(APPROOT . "/views/includes/header.php");
?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card card-body bg-light mt-5">
                    <h1>Post a comment</h1>
                    <form action="<?php echo URLROOT; ?>/comments/create/<?php echo $data["topic_id"]; ?>/<?php echo $data["thread_id"]; ?>"
                          method="POST">
                        <div class="form-group">
                            <label for="comment_text">Your comment</label>
                            <textarea
                                    class="form-control  <?php echo(!empty($data["comment_err"]) ? "is-invalid" : "") ?>"
                                    name="comment_text" id="comment" cols="30" rows="10"
                                    value=<?php $data["comment_text"] ?>></textarea>
                            <small class="form-text text-muted">Write something that delivers value to the
                                thread.</small>
                            <span class="invalid-feedback"><?php echo $data["comment_err"] ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Post now!</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php
require(APPROOT . "/views/includes/footer.php");