function getFormattedDate() {
  const dateInput = document.getElementById("date").value;
  const dateParts = dateInput.split("-");
  return `${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`;
}

function loadAttendance() {
  const url = window.location.origin + "/api/getAttendance.php";
  const headers = {
    "Content-Type": "application/x-www-form-urlencoded",
  };

  const params = new URLSearchParams({
    program: document.getElementById("program").value,
    semester: document.getElementById("semester").value,
    section: document.getElementById("section").value,
    subject_code: document.getElementById("subject").value,
    date: getFormattedDate(),
  });

  fetch(url, {
    method: "POST",
    headers: headers,
    body: params.toString(),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.text();
    })
    .then((data) => {
      document.getElementsByTagName("section")[0].style.display = "none";
      document.getElementsByTagName("main")[0].style.paddingTop = "2rem";

      generateTable(data);
      generateHiddenForm();

      document.getElementById("form").style.display = "block";
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
}

function generateTable(studentRecord) {
  const table = document.getElementById("table");
  const tableBody = table.getElementsByTagName("tbody")[0];
  var students = JSON.parse(studentRecord);

  students.forEach((student) => {
    const row = document.createElement("tr");

    const rollNo = document.createElement("td");
    rollNo.textContent = student.roll_no;
    row.appendChild(rollNo);

    const name = document.createElement("td");
    name.textContent = student.student_name;
    row.appendChild(name);

    const status = document.createElement("td");
    status.innerHTML =
      '<input type="hidden" name="name[]" value="' +
      student.student_name +
      '"/>';

    if (student.status == "present") {
      status.innerHTML +=
        '<input type="radio" name="status[' +
        student.roll_no +
        '][]" value="present" checked /> Present' +
        "&emsp;" +
        '<input type="radio" name="status[' +
        student.roll_no +
        '][]" value="absent" /> Absent';
    } else if (student.status == "absent") {
      status.innerHTML +=
        '<input type="radio" name="status[' +
        student.roll_no +
        '][]" value="present" /> Present' +
        "&emsp;" +
        '<input type="radio" name="status[' +
        student.roll_no +
        '][]" value="absent" checked/> Absent';
    }
    row.appendChild(status);

    tableBody.appendChild(row);
  });
}

function generateHiddenForm() {
  var program = document.getElementById("program").value;
  var semester = document.getElementById("semester").value;
  var section = document.getElementById("section").value;
  var subjectCode = document.getElementById("subject").value;

  const form = document.getElementById("form");
  const hiddenDiv = document.createElement("div");
  hiddenDiv.style.display = "none";
  hiddenDiv.innerHTML =
    '<input type="hidden" name="program" value="' +
    program +
    '"/>' +
    '<input type="hidden" name="semester" value="' +
    semester +
    '"/>' +
    '<input type="hidden" name="section" value="' +
    section +
    '"/>' +
    '<input type="hidden" name="subject_code" value="' +
    subjectCode +
    '"/>' +
    '<input type="hidden" name="created_on" value="' +
    getFormattedDate() +
    '"/>';
  form.appendChild(hiddenDiv);
}
