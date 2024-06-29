<?php
require_once '../src/globalHeader.php';
authorize('teacher');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../res/css/theme.css" />
    <link rel="stylesheet" href="../res/css/teacher.css" />
    <link rel="icon" type="image/x-icon" href="../res/img/favicon.png" />
    <script src="../res/js/teacher.js"></script>
    <title>Teacher Dashboard | Mechi Multiple Campus</title>
  </head>
  <body>
    <header>
      <button
        type="button"
        id="branding"
        onclick="window.location.href = window.location.origin;"
      >
        <img src="../res/img/TU-Logo.svg.png" alt="TU Logo" />
        <h2>Mechi Multiple Campus</h2>
      </button>
      <button
        type="button"
        id="logout"
        onclick="window.location.href = window.location.origin + '/src/logout.php';"
      >
        Log out
      </button>
    </header>
    <main>
      <div id="title">Teacher Dashboard</div>
      <details open>
        <summary>Attendance</summary>
        <article>
          <section>
            <img src="../res/img/notebook.png" alt="notebook" />
            <a
              href="./teacher/new-attendance/create.php"
              class="hgroup"
            >
              <h3>New Attendance</h3>
              <h3 class="Nepali">नयाँ हाजिरी</h3>
            </a>
          </section>
          <section>
            <img src="../res/img/rejected.png" alt="rejected" />
            <a 
              href="./teacher/update-attendance/modify.php" 
              class="hgroup">
              <h3>Attendance Correction</h3>
              <h3 class="Nepali">हाजिरी सच्चाउने</h3>
            </a>
          </section>
          <section>
            <img src="../res/img/printer.png" alt="printer" />
            <a href="#" class="hgroup">
              <h3>Print Attendance</h3>
              <h3 class="Nepali">हाजिरी निकाल्ने</h3>
            </a>
          </section>
        </article>
      </details>

      <details>
        <summary>Marksheet</summary>
        <article>
          <section>
            <img src="../res/img/notebook.png" alt="notebook" />
            <a href="#" class="hgroup">
              <h3>Marks Entry</h3>
              <h3 class="Nepali">अंक प्रविष्टि</h3>
            </a>
          </section>
          <section>
            <img src="../res/img/rejected.png" alt="rejected" />
            <a href="#" class="hgroup">
              <h3>Internal Assessment</h3>
              <h3 class="Nepali">आन्तरिक मूल्याङ्कन</h3>
            </a>
          </section>
          <section>
            <img src="../res/img/printer.png" alt="printer" />
            <a href="#" class="hgroup">
              <h3>Print Marksheet</h3>
              <h3 class="Nepali">मार्कसिट निकाल्ने</h3>
            </a>
          </section>
        </article>
      </details>

      <details>
        <summary>Report Generation</summary>
        <article>
          <section>
            <img src="../res/img/printer.png" alt="printer" />
            <a href="../template/attendance-report.php" class="hgroup">
              <h3>Attendance Report</h3>
              <h3 class="Nepali">हाजिरी प्रतिवेदन</h3>
            </a>
          </section>
        </article>
      </details>
    </main>
  </body>
</html>
