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
        <?php if (!isset($data["subscribed_topics"]) || $data["subscribed_topics"] == 0): ?>
            <p>You have not yet subscribed any topics. </p>
            <button class="btn btn-link">Explore Topics</button>
        <?php endif; ?>
        <a href="<?php echo URLROOT ?>/topics/createTopic">
            <button class="btn btn-primary">Create Topic</button>
        </a>

    </div>


<?php

require(APPROOT . "/views/includes/footer.php");
