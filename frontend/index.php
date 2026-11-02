<?php
// Uses the ONE shared navbar/footer (includes/header.php + footer.php).
$page_title = 'Nexusolutions | Smart Software Solutions';
$page_desc  = 'Websites, software, mobile apps and technical support for your business.';
$active     = 'home';
include 'includes/header.php';
?>

<!-- Welcome section -->
<section class="welcome"><div class="container">
  <div class="welcome-text"><h1>Smart Software Solutions for Your Business</h1>
  <p>We build websites, software and mobile apps, and we help keep them running. Tell us what you need and follow your request until it is done.</p>
  <div class="button-row"><a href="contact.php" class="btn-primary">Contact Us</a><a href="services.php" class="btn-outline">Our Services</a></div></div>
  <div class="welcome-image"><img src="images/hero.svg" alt="Illustration of a website on a laptop and a phone"></div>
</div></section>
<!-- Service cards -->
<section class="section"><div class="container"><h2 class="section-title">What We Do</h2>
<div class="card-grid">
<div class="service-card"><img src="images/web.svg" alt=""><h3>Website Development</h3><p>Fast, mobile-friendly websites for your business.</p></div>
<div class="service-card"><img src="images/software.svg" alt=""><h3>Software Development</h3><p>Custom programs built around how you work.</p></div>
<div class="service-card"><img src="images/mobile.svg" alt=""><h3>Mobile Applications</h3><p>Apps that work well on phones and tablets.</p></div>
<div class="service-card"><img src="images/support.svg" alt=""><h3>Technical Support</h3><p>Help when something breaks or needs updating.</p></div>
</div></div></section>
<!-- Why choose us -->
<section class="section why-us"><div class="container"><h2>Why Choose Us</h2>
<ul class="why-list">
<li><strong>Clear communication</strong>You always know what is included.</li>
<li><strong>Status you can follow</strong>Every inquiry is marked Pending, In Progress or Completed.</li>
<li><strong>Simple, clean code</strong>Easy for you or the next developer to maintain.</li>
<li><strong>Support after launch</strong>We stay available once your project is live.</li>
</ul></div></section><section class="cta-strip"><div class="container"><h2>Ready to start your project?</h2><a href="contact.php" class="btn-primary">Contact Us</a></div></section>

<?php include 'includes/footer.php'; ?>
