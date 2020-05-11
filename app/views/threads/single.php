<?php
require(APPROOT . "/views/includes/header.php");
?>
    <div class="container">
        <h1><?php echo $data["thread"]->name; ?></h1>
        <?php if (!isset($data["comments"]) || $data["comments"] == [] || $data["comments"] == "") : ?>
            <p>There are currently no comments in this thread.</p>
            <a href="<?php echo URLROOT; ?>/comments/create/<?php echo $data["thread"]->topic_id; ?>/<?php echo $data["thread"]->id; ?>">
                <button class="btn btn-primary">Be the first to comment on this thread</button>
            </a>
        <?php
        else:
            ?>
            <a href="<?php echo URLROOT; ?>/comments/create/<?php echo $data["thread"]->topic_id ?>/<?php echo $data["thread"]->id; ?>">
                <button class="btn btn-primary">Post a comment
                    
                </button>
            </a>

            <ul class="list-group list-group-flush">
                <?php
                foreach ($data["comments"] as $comment) {
                    ?>
                    <li class="list-group-item"><?php echo $comment->text ?>
                        <div>
                            <small>By: <?php echo $comment->user_name; ?>
                                on <?php echo date("F d, Y", strtotime($comment->date)); ?></small>
                        </div>


                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php
        endif; ?>
    </div>
<?php
require(APPROOT . "/views/includes/footer.php");
?>