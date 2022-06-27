<?php $education = get_education(); ?>
<?php if (!empty($education)) : ?>
    <section>
        <h2>Education</h2>
        <?php foreach($education as $school): ?>
            <div class="item-box <?php echo get_filter_classes($school->skills); ?>">
                <time><?php echo $school->timespan ?></time>
                <br />
                <h3>
                    <?php echo $school->institution; ?>
                    <?php if(!empty($school->location)) : ?>
                        <?php echo ', '; ?>
                        <?php echo $school->location; ?>
                    <?php endif; ?>
                    <?php if(!empty($school->degree) || !empty($school->fields_of_study)) : ?>
                        <br />
                    <?php endif; ?>
                    <?php if(!empty($school->degree)) : ?>
                        <span class="teal-text"><?php echo $school->degree; ?></span>
                    <?php endif; ?>
                    <?php if(!empty($school->degree) && !empty($school->fields_of_study)) : ?>
                        <?php echo ' - '; ?>
                    <?php endif; ?>
                    <?php if(!empty($school->fields_of_study)) : ?>
                        <em><?php echo $school->fields_of_study; ?></em>
                    <?php endif; ?>
                </h3>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
