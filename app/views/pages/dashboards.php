<?php
/*
 * The "starting point" for logged in users
 * displays all subscribed topics
 * Also delivers search bar and explore opportunities
 */


require(APPROOT . "/views/includes/header.php");
?>

<div class="container">

    <?php
    if (isset($_SESSION["newly_registered"])) { ?>
    <h1>Newly registered</h1>

    <?php
        unset($_SESSION["newly_registered"]);
    } ?>

    <h1>Dashboard</h1>
    <h2>Hello, <?php echo $_SESSION["user_username"]; ?></h2>
    <h2>Subscribed topics</h2>
    <!-- TODO: send data from controller to display subscribed topics here -->
    <?php if (!isset($data["subscribed_topics"]) || $data["subscribed_topics"] == 0) : ?>
    <p>You have not yet subscribed any topics. </p>
    <button class="btn btn-link">Explore Topics</button>
    <?php else :
        ?>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <?php
                foreach ($data["subscribed_topics"] as $topic) {
                    ?>
        <a href="topics/single/<?php echo $topic->id ?>">
            <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark"><?php echo $topic->name; ?></strong>
                    <?php echo $topic->description; ?>
                </p>
            </div>
        </a>

        <?php
            }
        endif;
        ?>
    </div>

    <a href="<?php echo URLROOT ?>/topics/createTopic">
        <button class="btn btn-primary">Create Topic</button>
    </a>
</div>


<?php

require(APPROOT . "/views/includes/footer.php");