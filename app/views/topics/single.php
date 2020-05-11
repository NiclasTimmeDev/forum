<?php
require(APPROOT . "/views/includes/header.php");
?>

    <div class="container">
        <?php switch ($data["error-code"]) {
            case 1:
                ?>
                <div class="alert alert-warning" role="alert">
                    You are already subscribed
                </div>
                <?php
                break;
            case 2: ?>
                <div class="alert alert-danger" role="alert">
                    Sorry, something went wrong. Try again later.
                </div>
            <?php
            case 3:
                ?>
                <div class="alert alert-success" role="alert">
                    Congrats! You are now subscribed!
                </div>
                <?php
                break;
            default:
                ?>
            <?php
        } ?>

        <h1><?php echo $data["topic_name"]; ?></h1>
        <?php if (!isset($data["user_is_subscribed"]) || $data["user_is_subscribed"] == false) {
            ?>
            <form action="<?php echo URLROOT ?>/topics/subscribe" method="POST">
                <button name="topic_id" value="<?php echo $data["topic_id"] ?>" type="submit" class="btn btn-primary">
                    Subscribe
                    now!
                </button>
            </form>
            <?php

        } ?>


        <h2>Threads</h2>
        <a href="<?php echo URLROOT; ?>/threads/create/<?php echo $data["topic_id"]; ?>">
            <button class="btn btn-primary">Create Thread</button>
        </a>
        <?php if (!isset($data["threads"]) || $data["threads"] == []): ?>
            <p>There are no threads for this topic</p>
            <a href="<?php echo URLROOT; ?>/threads/create/<?php echo $data["topic_id"]; ?>">Create Thread</a>
        <?php else :
            ?>
            <ul class="list-group list-group-flush">
                <?php
                foreach ($data["threads"] as $thread) {
                    ?>
                    <li class="list-group-item"><?php echo $thread->name ?>
                        <div><a
                                    href="<?php echo URLROOT; ?>/threads/single/<?php echo $data["topic_id"]; ?>/<?php echo $thread->id; ?>">More</a>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        <?php endif; ?>

    </div>


<?php
require(APPROOT . "/views/includes/footer.php");
?>