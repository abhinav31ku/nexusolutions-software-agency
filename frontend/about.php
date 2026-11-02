<?php
// Uses the ONE shared navbar/footer (includes/header.php + footer.php).
$page_title = 'About Us | Nexusolutions';
$page_desc  = 'Who we are, our mission and how we work.';
$active     = 'about';
include 'includes/header.php';
?>

<section class="page-banner"><div class="container"><h1>About Us</h1></div></section>
<section class="section"><div class="container about-intro">
  <div><h2>Who We Are</h2><p>Nexusolutions is a small software company. We build websites, software and mobile apps for growing businesses, and we keep you updated at every stage of the work.</p></div>
  <img src="images/hero.svg" alt="Illustration of a website and a phone app">
</div></section>
<section class="section section-white"><div class="container two-boxes">
  <div class="info-box"><h3>Our Mission</h3><p>To make good software simple and affordable for small and growing businesses.</p></div>
  <div class="info-box"><h3>Our Goals</h3><p>Deliver on time, explain things in plain language, and write code that is easy to maintain.</p></div>
</div></section>
<section class="section"><div class="container"><h2 class="section-title">How We Work</h2>
<div class="process">
<div><h3>Listen</h3><p>You send an inquiry describing what you need.</p></div>
<div><h3>Plan</h3><p>We agree on the work and the timeline.</p></div>
<div><h3>Build</h3><p>We create your project and share progress.</p></div>
<div><h3>Deliver</h3><p>You review the result and we hand it over.</p></div>
</div></div></section><section class="cta-strip"><div class="container"><h2>Ready to start your project?</h2><a href="contact.php" class="btn-primary">Contact Us</a></div></section>

<?php include 'includes/footer.php'; ?>
