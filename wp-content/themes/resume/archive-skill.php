<?php $skills = get_skills(true); ?>
<?php if (!empty($skills)) : ?>
    <section class="mt-8">
        <script type="text/javascript">
            function setCookie(name, value, days = 7) {
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = 'filter-' + name + "=" + (value || "")  + expires + "; path=/";
            }

            function getCookie(name) {
                var nameEQ = 'filter-' + name + "=";
                var ca = document.cookie.split(';');
                for(var i = 0;i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return boolval(c.substring(nameEQ.length, c.length));
                }
                return false;
            }

            function eraseCookie(name) {
                document.cookie = 'filter-' + name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            }

            function hasAnyAppliedFilters() {
                return document.cookie.includes('filter-');
            }

            function setActive(target) {
                target.classList.add('active');
                var skill = target.id;
                console.log(target.id);
                setCookie(skill, true);
                applyFilters();
            }

            function unsetActive(target) {
                target.classList.remove('active');
                var skill = target.id;
                eraseCookie(skill);
                applyFilters();
            }

            function hideIrrelevant(target) {
                target.classList.add('gray-out');
            }

            function showRelevant(target) {
                target.classList.remove('gray-out');
            }

            function showAll() {
                var toShow = document.getElementsByClassName('filter');
                for (let i = 0; i < toShow.length; i++) {
                    showRelevant(toShow[i]);
                }
            }

            function hideAll() {
                var toHide = document.getElementsByClassName('filter');
                for (let i = 0; i < toHide.length; i++) {
                    hideIrrelevant(toHide[i]);
                }
            }

            function applyFilters() {
                if (!hasAnyAppliedFilters()) {
                    showAll();
                    return;
                }
                hideAll();
                var ca = document.cookie.split(';');
                for (var i = 0 ; i < ca.length ; i++) {
                    var c = ca[i].trim().split('=')[0];
                    if (c.startsWith('filter-')) {
                        console.log(c);
                        var relevant = document.getElementsByClassName(c);
                        for (let i = 0; i < relevant.length; i++) {
                            showRelevant(relevant[i]);
                        }
                    }
                }
            }

            function onClick(e) {
                var target = e.target,
                    isActive = e.target.classList.contains('active');

                if (isActive) {
                    unsetActive(target);
                } else {
                    setActive(target);
                }
                applyFilters();
            }

            function clearAll(e) {
                var buttons = document.getElementsByTagName('button');
                for (let i = 0; i < buttons.length; i++) {
                    let button = buttons[i];
                    unsetActive(button);
                }
            }
        </script>
        <div class="flex-container mb-quarter">
            <div class="white-text flex-item no-padding bottom-up-2">Filter</div>
            <div class="white-text flex-item no-padding">
                <svg
                    class="bi bi-x float-right"
                    fill="currentColor"
                    height="18"
                    onclick="clearAll()"
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
                class="badge badge-default <?php echo isset($_COOKIE['filter-' . $skill->name]) ? 'active' : ''; ?>"
                id="<?php echo $skill->name; ?>"
                onclick="onClick(event)"
            >
                <?php echo $skill->skill; ?>
            </button>
        <?php endforeach; ?>
    </section>
<?php endif; ?>
