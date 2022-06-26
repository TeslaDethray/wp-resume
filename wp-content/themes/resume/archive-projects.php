<section>
    <h2>Projects</h2>
    <?php $projects = get_projects(); ?>
    <?php foreach($projects as $project): ?>
        <h3>
            <?php echo $project->title; ?>
        </h3>
        <a href="<?php echo $project->url; ?>"><?php echo $project->url; ?></a>
        <p>
            <?php echo $project->description; ?>
        </p>
        <?php if (!empty($project->skills)) : ?>
            <p>
                <strong>
                    <?php echo implode(', ', array_map(
                        function ($skill) {
                            return $skill->skill;
                        },
                        $project->skills
                    )); ?>
                </strong>
            </p>
        <?php endif?>
    <?php endforeach; ?>
</section>
