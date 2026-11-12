<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'Projects | Nexusolutions';
$page_desc = 'Sample projects made to show our style.';
$active = 'projects';
include __DIR__ . '/../includes/header.php';
?>
<section class="page-title">
  <div class="container">
    <h1>Projects</h1>
    <p class="muted">These are sample projects we made to show our style. They are not client work.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="filter-bar">
      <button type="button" class="filter-button active" data-category="all">All</button>
      <button type="button" class="filter-button" data-category="website">Websites</button>
      <button type="button" class="filter-button" data-category="software">Software</button>
      <button type="button" class="filter-button" data-category="mobile">Mobile</button>
    </div>

    <div class="project-list">
      <article class="project-item" data-category="website">
        <p class="project-tag">Website</p>
        <h2>Cafe website</h2>
        <p>Menu page, opening hours and a contact form. Works on phones.</p>
        <p class="project-tech">HTML, CSS, JavaScript</p>
      </article>
      <article class="project-item" data-category="software">
        <p class="project-tag">Software</p>
        <h2>Inventory tracker</h2>
        <p>Keeps stock counts in a database. Staff log in and update items.</p>
        <p class="project-tech">PHP, MySQL</p>
      </article>
      <article class="project-item" data-category="mobile">
        <p class="project-tag">Mobile</p>
        <h2>Workout planner</h2>
        <p>Screens for planning a week of workouts and ticking them off.</p>
        <p class="project-tech">Design mockups</p>
      </article>
    </div>

    <p class="muted">Want something similar? <a href="contact.php" class="text-link">Send an inquiry</a>.</p>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
