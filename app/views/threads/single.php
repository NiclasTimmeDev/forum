<?php
require(APPROOT . "/views/includes/header.php");
print_r($data);
?>
<div class="container">
    <h1><?php echo $data["thread"]->name; ?></h1>
    <?php if (!isset($data["comments"]) || $data["comments"] == [] || $data["comments"] == "") : ?>
    <p>There are currently no comments in this thread.</p>
    <a href="threads/create/" <?php echo $data["thread"]->topic_id; ?>>
        <button class="btn btn-primary">Be the first to comment on this thread</button>
    </a>

    <?php endif; ?>
</div>
<?php
require(APPROOT . "/views/includes/footer.php");
?>