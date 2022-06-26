<section>
    <?php $summary = get_summary(); ?>
    <?php echo $summary->phone_number; ?>
    <br />
    <?php echo $summary->email; ?>
    <br />
    <a href="<?php echo $summary->github_url; ?>">
      <?php echo $summary->github_url; ?>
    </a>
    <br />
    <a href="<?php echo $summary->linkedin_url; ?>">
      <?php echo $summary->linkedin_url; ?>
    </a>
    <p>
        <?php echo $summary->summary; ?>
    </p>
</section>
