<?php $projects = get_projects(); ?>
<?php if(!empty($projects)) : ?>
    <section>
        <h2>Projects</h2>
        <?php foreach($projects as $project): ?>
            <div class="item-box">
                <h3 class="mb-quarter">
                    <?php echo $project->title; ?>
                </h3>
                <a href="<?php echo $project->url; ?>"><?php echo $project->url; ?></a>
                <p>
                    <?php echo $project->description; ?>
                    <?php if (!empty($project->skills)) : ?>
                        <br />
                        <strong>
                            <?php echo implode(', ', array_map(
                                function ($skill) {
                                    return $skill->skill;
                                },
                                $project->skills
                            )); ?>
                        </strong>
                    <?php endif?>
                </p>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
