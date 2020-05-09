<?php
require(APPROOT . "/views/includes/header.php");
print_r($data);
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h1>Create a thread</h1>
                <form action="<?php echo URLROOT; ?>/threads/create/<?php echo $data["topic_id"]; ?>" method="POST">
                    <div class="form-group">
                        <label for="thread_name">Name</label>
                        <input type="text"
                            class="form-control <?php echo (!empty($data["thread_name_err"]) ? "is-invalid" : "") ?>"
                            id="thread_name" name="thread_name" value=<?php $data["thread_name"] ?>>
                        <small class="form-text text-muted">This should be a question that other users can answer
                            to.</small>
                        <span class="invalid-feedback"><?php echo $data["thread_name_err"] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="thread_description">Description</label>
                        <textarea
                            class="form-control  <?php echo (!empty($data["thread_description_err"]) ? "is-invalid" : "") ?>"
                            name="thread_description" id="thread_description" cols="30" rows="10"
                            value=<?php $data["thread_description"] ?>></textarea>
                        <small class="form-text text-muted">Explain your question in more detail.</small>
                        <span class="invalid-feedback"><?php echo $data["thread_description_err"] ?></span>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Thread</button>
                </form>
            </div>
        </div>
    </div>

</div>


<?php
require(APPROOT . "/views/includes/footer.php");
?>