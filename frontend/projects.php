<?php
// Uses the ONE shared navbar/footer (includes/header.php + footer.php).
$page_title = 'Projects | Nexusolutions';
$page_desc  = 'Sample website, software and mobile projects.';
$active     = 'projects';
include 'includes/header.php';
?>

<section class="page-banner"><div class="container"><h1>Our Projects</h1><p class="subtitle">These are sample projects made to show our style. They are demonstrations, not real client work.</p></div></section>
<section class="section"><div class="container">
<div class="filter-buttons"><button class="active" data-category="all">All</button><button data-category="website">Websites</button><button data-category="software">Software</button><button data-category="mobile">Mobile</button></div>
<div class="project-grid"><div class="project-card" data-category="website"><div class="project-image"><img src="images/web.svg" alt=""></div><div class="project-info"><span class="demo-label">Sample project</span><h3>Sample: Cafe Website</h3><p>A simple responsive website with a menu page and contact form.</p></div></div><div class="project-card" data-category="software"><div class="project-image"><img src="images/software.svg" alt=""></div><div class="project-info"><span class="demo-label">Sample project</span><h3>Sample: Inventory Tracker</h3><p>A small program to track stock, with a login and a database.</p></div></div><div class="project-card" data-category="mobile"><div class="project-image"><img src="images/mobile.svg" alt=""></div><div class="project-info"><span class="demo-label">Sample project</span><h3>Sample: Fitness App</h3><p>Screens for a workout planner on a phone.</p></div></div></div>
<p class="note">Want something similar? <a href="contact.php">Send us an inquiry</a>.</p></div></section>

<?php include 'includes/footer.php'; ?>
