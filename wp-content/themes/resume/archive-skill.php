<?php $skills = get_skills(true); ?>
<?php if (!empty($skills)) : ?>
    <section class="filter-list mt-8">
        <div class="flex-container mb-quarter">
            <div class="white-text flex-item no-padding bottom-up-2">Filter</div>
            <div class="white-text flex-item no-padding">
                <svg
                    class="bi bi-x float-right"
                    fill="currentColor"
                    height="18"
                    onclick="resetAllFilters()"
                    viewBox="0 0 16 16"
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                >
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
        </div>
        <?php foreach($skills as $skill): ?>
            <button
                class="badge badge-default filterer"
                id="<?php echo $skill->name; ?>"
                onClick='toggleFilter(event)'
            >
                <?php echo $skill->skill; ?>
            </button>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
