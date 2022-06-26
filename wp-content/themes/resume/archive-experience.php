<?php $experience = get_experience(); ?>
<?php if (!empty($experience)) : ?>
    <section>
        <h2>Experience</h2>
        <?php foreach($experience as $job): ?>
            <div class="item-box">
                <time><?php echo $job->timespan ?></time>
                <br />
                <h3 class="mt-half">
                    <?php echo $job->company; ?>,
                    <?php echo $job->location; ?>
                    <?php echo ' - '; ?>
                    <em><?php echo $job->job_title; ?></em>
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
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
