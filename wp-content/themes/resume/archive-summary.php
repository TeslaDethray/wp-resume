<?php $summary = get_summary(); ?>
<?php if(!empty($summary) && !empty($summary->summary)) : ?>
    <section>
        <div class="item-box">
            <?php echo $summary->summary; ?>
        </div>
    </section>
<?php endif; ?>
