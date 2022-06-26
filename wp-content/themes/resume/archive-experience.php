<section>
    <h2>Experience</h2>
    <?php $experience = get_experience(); ?>
    <?php foreach($experience as $job): ?>
        <time><?php echo $job->timespan ?></time>
        <br />
        <h3>
            <?php echo $job->company; ?>,
            <?php echo $job->location; ?>
            <?php echo ' - '; ?>
            <?php echo $job->job_title; ?>
        </h3>
        <p>
            <?php echo $job->description; ?>
        </p>
        <?php if(count($job->events) > 1) : ?>
            <ul>
                <?php foreach($job->events as $event) : ?>
                    <li>
                        <?php echo $event->what_did_you_do; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if(count($job->events) === 1) : ?>
            <?php $event = array_shift($job->events); ?>
            <?php echo $event->what_did_you_do; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
