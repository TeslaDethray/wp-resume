const badgeClass = 'filterer';
const cookieName = 'filter';
const filterableClass = 'filter';

/*********************************************
 * Cookie Functions
 *********************************************/

/**
 * Resets the filter cookie to an empty object
 */
function eraseFilterCookie() {
  document.cookie = cookieName + '=' + JSON.stringify({}) + getCookieExpiry();
  showAll();
}

/**
 * Generates an expiration date for the cookie
 * @param days
 * @returns {string}
 */
function getCookieExpiry(days = 1) {
  var date = new Date();
  date.setTime(date.getTime() + (days*24*60*60*1000));
  return "; expires=" + date.toUTCString();
}

/**
 * Returns either the object containing all filters or the one requested by name
 * @param name
 * @returns {boolean|object}
 */
function getFilterCookie(name = null) {
  const nameEq = cookieName + '=';
  const ca = document.cookie.split(';');
  for(let i = 0 ; i < ca.length ; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEq) == 0) {
      const data = JSON.parse(c.substring(nameEq.length, c.length));
      if (!name) {
        return data;
      }
      if (data.hasOwnProperty(name)) {
        return data[name];
      }
    }
  }
  return false;
}

/**
 * Determines whether no filters applied at all
 * @return {boolean}
 */
function noFiltersAreApplied() {
  return !Object.values(getFilterCookie()).includes(true);
  return !Object.values(getFilterCookie()).includes(true);
}

/**
 * Sets the cookie named to the value given
 * @param name
 * @param value
 */
function setFilterCookie(name, value = true) {
  const filters = getFilterCookie();
  filters[name] = value;
  document.cookie = cookieName + '=' + JSON.stringify(filters)  + getCookieExpiry() + "; path=/";
}

/*********************************************
 * GUI Functions
 *********************************************/

/**
 * Adds the active class to the element with this ID
 * @param target
 */
function activateButton(target) {
  target.classList.add('active');
}

/**
 * Removes the active class from all filterers
 */
function deactivateAll() {
  for (let target of document.getElementsByClassName(badgeClass)) {
    deactivateButton(target);
  }
}

/**
 * Removes the active class from the element with this ID
 * @param target
 */
function deactivateButton(target) {
  target.classList.remove('active');
}

/**
 * Will apply the hide styles to every filterable element
 */
function hideAll() {
  const toHide = document.getElementsByClassName(filterableClass);
  for (let i = 0; i < toHide.length; i++) {
    hideIrrelevant(toHide[i]);
  }
}

/**
 * Applies the hide styles to the targeted element
 * @param target
 */
function hideIrrelevant(target) {
  target.classList.add('gray-out');
}

/**
 * Will remove the hide styles from every filterable element
 */
function showAll() {
  const toShow = document.getElementsByClassName(filterableClass);
  for (let i = 0; i < toShow.length; i++) {
    showRelevant(toShow[i]);
  }
}

/**
 * Removes the hide styles from the targeted element
 * @param target
 */
function showRelevant(target) {
  target.classList.remove('gray-out');
}

/*********************************************
 * Combined GUI-Cookie Functions
 *********************************************/

/**
 * When a filterer button is clicked the filter and the active styles are toggled
 * @param e The event that triggered this
 */
function toggleFilter(e) {
  const { target } = e;
  const status = getFilterCookie(target.id);
  setFilterCookie(target.id, !status);
  if (status) {
    deactivateButton(target);
  } else {
    activateButton(target);
  }
  updateFilterables();
}

/**
 * Resets the cookie, removes all filters, deactivates all buttons
 */
function resetAllFilters() {
  eraseFilterCookie();
  deactivateAll();
  showAll();
}

/**
 * Updates the status of all filterable elements on the page
 */
function updateFilterables() {
  if (noFiltersAreApplied()) {
    showAll();
  } else {
    hideAll();
    const filters = getFilterCookie();
    for (let targetName of Object.keys(filters)) {
      if (filters[targetName]) {
        const relevantElements = document.getElementsByClassName(filterableClass + ' ' + targetName);
        for (let target of relevantElements) {
          showRelevant(target);
        }
      }
    }
  }
}
