<?php
require(APPROOT . "/views/includes/header.php");
?>


<div class="container">
    <h1>All topics</h1>
    <p>Find the topics you are interested in.</p>
    <ul class="list-group list-group-flush">
        <?php foreach ($data as $topic) { ?>
        <li class="list-group-item"><strong><?php echo $topic->name ?></strong>
            <div><?php echo $topic->description ?></div>
            <a href="<?php echo URLROOT; ?>/topics/single/<?php echo $topic->id; ?>">
                More
            </a>
        </li>
        <?php } ?>
    </ul>

</div>



<?php
require(APPROOT . "/views/includes/footer.php");
?>