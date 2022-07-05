<?php if ( is_active_sidebar( 'resume_photos' ) ) : ?>
    <section>
        <h2>About Me</h2>
        <p><?php dynamic_sidebar('resume_personal') ?></p>
        <div class="photo photo--responsive flex-container">
            <?php dynamic_sidebar( 'resume_photos' ); ?>
        </div>
    </section>
<?php endif; ?>
