<?php
require_once '../../../src/globalHeader.php';
authorize('teacher');

require_once '../../../src/selectDataGenerator.php';
$selectOptions = getClasses();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once '../../../src/databaseManager.php';
  $conn = establishConnectionToDB();

  if(!$conn) {
      die('Connection to database failed!');
  }
  else {
      $program = $_POST['program'];
      $semester = $_POST['semester'];
      $section = $_POST['section'];
      $subject_code = $_POST['subject_code'];
      $names = $_POST['name'];
      $created_on = $_POST['date-picker'];
      
      for ($i = 0; $i < count($names); $i++) {
        $roll_number = array_keys($_POST['status'])[$i];
        $status = $_POST['status'][$roll_number][0];

        $pst = $conn->prepare("INSERT INTO `attendance`(`student_name`, `program`, `semester`, `section`, `roll_no`, `subject_code`, `status`, `created_on`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $pst->bind_param("ssisisss", $names[$i], $program, $semester, $section, $roll_number, $subject_code ,$status, $created_on);
        $pst->execute();
      }
      if($pst -> affected_rows > 0) {
        $pst->close();
        header('Location: ../../done.html');
        $conn->close();
        exit();
      } else {
        echo "Some error has occured!";
        $conn -> close();
        exit();
      }
  }
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Attendance | Mechi Multiple Campus</title>
    <link rel="stylesheet" href="../../../res/css/theme.css" />
    <link rel="stylesheet" href="../../../res/css/attendance.css" />
    <link rel="stylesheet" href="../../../res/css/select.css" />
    <link rel="icon" type="image/x-icon" href="../../../res/img/favicon.png" />
    <!-- Nepali Datepicker CSS -->
    <link href="../../../res/nepali-date-picker/nepali.datepicker.min.css" rel="stylesheet" type="text/css" />
    <script src="../../../res/js/select.js"></script>
    <script src="../../../res/js/new-attendance.js"></script>
    <script>
      const classes = <?php echo json_encode($selectOptions)?>;
    </script>
  </head>
  <body>
    <header>
      <button
        type="button"
        id="branding"
        onclick="window.location.href = window.location.origin;"
      >
        <img src="../../../res/img/TU-Logo.svg.png" alt="TU Logo" />
        <h2>Mechi Multiple Campus</h2>
      </button>
      <button
        id="logout"
        onclick="window.location.href = window.location.origin + '/src/logout.php';"
      >
        Log out
      </button>
    </header>

    <main>
      <section>
        <div class="selector">
          <label for="program">Program</label>
          <select name="program" id="program" onchange="filterSemestersAccordingToProgram()">
            <option value="">Select program</option>
            <?php
              $programs = array_unique(array_column($selectOptions, 'program'));
              foreach ($programs as $program) {
                  echo '<option value="'.$program.'">'.strtoupper($program).'</option>';
              }
            ?>
            <!-- <option value="bsc.csit">CSIT</option>
            <option value="bca">BCA</option> -->
          </select>
        </div>

        <div class="selector">
          <label for="semester">Semester</label>
          <select name="semester" id="semester" disabled onchange="filterSectionsAccordingToSemester()">
            <option value="">Select semester</option>
            <!-- this section will be filled with js  -->
            <!-- <option value="1">First</option>
            <option value="2">Second</option> -->
          </select>
        </div>

        <div class="selector">
          <label for="section">Section</label>
          <select name="section" id="section" disabled onchange="filterSubjectsAccordingToSection()">
            <option value="">Select section</option>
            <!-- this section will be filled with js  -->
            <!-- <option value="A">A</option>
            <option value="B">B</option> -->
          </select>
        </div>

        <div class="selector">
          <label for="subject">Subject</label>
          <select name="subject" id="subject" disabled>
            <option value="">Select subject</option>
            <!-- <option value="csc115">C Programming</option> -->
          </select>
        </div>

        <div class="selector">
          <button type="button" onclick="loadStudents()" id="loader">
            &emsp;Load&emsp;
          </button>
        </div>
      </section>

      <form action="" method="POST" id="form" style="display:none">
        <?php
            echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
        ?>
        <div id="attendance-info">
          <div id="subject-info">
            <label for="subject-title"><b>Subject Title:</b></label>
            <input
              type="text"
              name="subject-title"
              id="subject-title"
              readonly
            />
          </div>
          <div id="date-info">
            <label for="date-picker"><b>Attendance Date:</b></label>
            <div>
              <input
                type="text"
                name="date-picker"
                id="date-picker"
                required
              />&#128197;
            </div>
          </div>
        </div>
        <table id="table">
          <thead>
            <tr>
              <th>Roll No.</th>
              <th>Name</th>
              <th>Attendance</th>
            </tr>
          </thead>
          <tbody>
            <!-- <tr>
              <td>1</td>
              <td>Neelam Karki</td>
              <td>
                <input
                  type="radio"
                  name="present"
                  value="present"
                  checked
                />present
                <input type="radio" name="absent" value="absent" />absent
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Bipul Karki</td>
              <td>
                <input type="radio" name="present" value="present" />present
                <input
                  type="radio"
                  name="absent"
                  value="absent"
                  checked
                />absent
              </td>
            </tr> -->
          </tbody>
        </table>
        <br />
        <button type="submit" id="submit">&emsp;Save Attendance&emsp;</button>
      </form>
    </main>
    <!-- Nepali Datepicker Script -->
    <script src="../../../res/nepali-date-picker/nepali.datepicker.min.js" type="text/javascript"></script>
  </body>
</html>
