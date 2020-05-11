<?php
require(APPROOT . "/views/includes/header.php");
?>
    <main>
        <section class="jumbotron text-center">
            <div class="container">
                <h1>THE FORUM</h1>
                <p class="lead text-muted">FORUM: The last forum you will ever need. No matter what you want to discuss
                    - you will find everything you search for and more on this Forum.</p>
                <p>
                    <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-primary my-2">Become a community
                        member</a>
                </p>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                             xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false"
                             role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"/>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>
                        <div class="card-body">
                            <p class="card-text">Create Topics in order to categorize the content you want to discuss
                                with your peers</p>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                             xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false"
                             role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"/>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>
                        <div class="card-body">
                            <p class="card-text">Within a topic you can ask questions, which are called "threads". These
                                can be answered by experts from the community.</p>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                             xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false"
                             role="img" aria-label="Placeholder: Thumbnail"><title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"/>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>
                        <div class="card-body">
                            <p class="card-text">Comment on threads to share your knowledge. Your fellow members will be
                                very grateful!</p>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </main>


<?php
require(APPROOT . "/views/includes/footer.php");