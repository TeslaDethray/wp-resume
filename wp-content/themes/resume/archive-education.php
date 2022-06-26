<section>
    <h2>Education</h2>
    <?php $education = get_education(); ?>
    <?php foreach($education as $school): ?>
        <div class="item-box">
            <time><?php echo $school->timespan ?></time>
            <br />
            <h3>
                <?php echo $school->institution; ?>
                <?php echo ', '; ?>
                <?php echo $school->location; ?>
                <?php echo ' - '; ?>
                <em><?php echo $school->fields_of_study; ?></em>
            </h3>
        </div>
    <?php endforeach; ?>
</section>
