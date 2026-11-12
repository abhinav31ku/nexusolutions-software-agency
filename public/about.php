<?php
require_once __DIR__ . '/../includes/auth.php';

$page_title = 'About | Nexusolutions';
$page_desc = 'The team behind Nexusolutions and how we work.';
$active = 'about';
include __DIR__ . '/../includes/header.php';
?>
<section class="page-title">
  <div class="container">
    <h1>About</h1>
  </div>
</section>

<section class="section">
  <div class="container text-column">
    <p>Nexusolutions started as a college project. We are six students and we split the work between the front end (pages and styling) and the back end (PHP and the database).</p>
    <p>We keep the tools simple: HTML, CSS, JavaScript, PHP and MySQL, with no frameworks. That makes the code easy to read, and easy for the next person to take over.</p>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <h2>Team</h2>
    <ul class="team-list">
      <li><span>Abhinav Kumar</span> Frontend</li>
      <li><span>Yogesh</span> Frontend</li>
      <li><span>Kanika Chaudhary</span> Frontend</li>
      <li><span>Vansh Jain</span> Database and backend</li>
      <li><span>Aaditya Raj Sharma</span> Database and backend</li>
      <li><span>Anurag Rathore</span> Database and backend</li>
    </ul>
  </div>
</section>

<section class="section">
  <div class="container text-column">
    <h2>How we work</h2>
    <p>We read every inquiry ourselves and answer within two working days. Before we start we agree on what is included and roughly how long it will take. While we work, the status of your inquiry is always visible under My inquiries.</p>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
