<?php
require(APPROOT . "/views/includes/header.php");
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h1>Create a topic</h1>
                <form action="<?php echo URLROOT; ?>/topics/createTopic" method="POST">
                    <div class="form-group">
                        <label for="topic_name">Name</label>
                        <input type="text"
                            class="form-control <?php echo (!empty($data["topic_name_err"]) ? "is-invalid" : "") ?>"
                            id="topic_name" name="topic_name" value=<?php $data["topic_name"] ?>>
                        <small class="form-text text-muted">This should describe the content that will be discussed in
                            this
                            topic.</small>
                        <span class="invalid-feedback"><?php echo $data["topic_name_err"] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="topic_description">Description</label>
                        <input type="text"
                            class="form-control  <?php echo (!empty($data["topic_description_err"]) ? "is-invalid" : "") ?>"
                            id="topic_description" name="topic_description" value=<?php $data["topic_description"] ?>>
                        <small class="form-text text-muted">Briefly describe the content of your topic.</small>
                        <span class="invalid-feedback"><?php echo $data["topic_description_err"] ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Topic</button>
                </form>
            </div>
        </div>
    </div>

</div>


<?php
require(APPROOT . "/views/includes/footer.php");
?>