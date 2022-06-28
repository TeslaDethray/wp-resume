<div class="flex-container header">
    <div class="flex-item">
        <h1>
            <?php bloginfo('name'); ?>
            <?php if (!empty(get_bloginfo('description'))) : ?>
                <br />
                <span class="offset-text">
                    <?php bloginfo('description'); ?>
                </span>
            <?php endif; ?>
        </h1>
    </div>
    <div class="flex-item">
        <?php $summary = get_summary(); ?>
        <?php if (!empty($summary) && (!empty($summary->github_url) || !empty($summary->linkedin_url))) : ?>
            <p>
                <?php if (!empty($summary->github_url)) : ?>
                    <a href="<?php echo $summary->github_url; ?>">
                        <?php echo $summary->github_url; ?>
                    </a>
                <?php endif; ?>
                <?php if (!empty($summary->linkedin_url)) : ?>
                    <br />
                    <a href="<?php echo $summary->linkedin_url; ?>">
                        <?php echo $summary->linkedin_url; ?>
                    </a>
                <?php endif; ?>
            </p>
        <?php endif; ?>
        <?php if (!empty($summary->resume_url)) : ?>
            <p>
                <a download href="<?php echo $summary->resume_url; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zm-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0z"/>
                    </svg>
                    <span class="bottom-up-2">Download PDF</span>
                </a>
            </p>
        <?php endif; ?>
    </div>
</div>
