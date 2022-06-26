<?php get_header(); ?>

<main class="main" role="main">
    <div class="container">
        <section>
            <h1>
		        <?php bloginfo('name'); ?>
		        <br />
		        <?php bloginfo('description'); ?>
            </h1>
            <?php include('archive-summary.php'); ?>
        </section>
        <section>
          <?php include('archive-experience.php'); ?>
        </section>
        <section>
            <?php include('archive-education.php'); ?>
        </section>
        <section>
            <?php include('archive-projects.php'); ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
