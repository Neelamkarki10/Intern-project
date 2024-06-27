window.onload = function () {
  const nepali_date = NepaliFunctions.GetCurrentBsDate();
  function addZero(num) {
    return num < 10 ? "0" + num : num;
  }
  const year = nepali_date.year;
  const month = addZero(nepali_date.month);
  const day1 = addZero(nepali_date.day - 1);
  const day2 = addZero(nepali_date.day);
  const before = year + "-" + month + "-" + day1;
  const after = year + "-" + month + "-" + day2;
  var mainInput = document.getElementById("date-picker");
  mainInput.value = after;
  mainInput.nepaliDatePicker({
    language: "english",
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 10,
    disableAfter: after,
  });
};

function loadStudents() {
  var program = document.getElementById("program").value;
  var semester = document.getElementById("semester").value;
  var section = document.getElementById("section").value;

  var selectSubject = document.getElementById("subject");
  var selectedSubject = selectSubject.options[selectSubject.selectedIndex].text;
  // console.log(selectedSubject);
  document.getElementById("subject-title").value = selectedSubject;

  var xhr = new XMLHttpRequest();

  xhr.open("POST", window.location.origin + "/api/getStudents.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  var params =
    "program=" +
    encodeURIComponent(program) +
    "&semester=" +
    encodeURIComponent(semester) +
    "&section=" +
    encodeURIComponent(section);
  xhr.send(params);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementsByTagName("section")[0].style.display = "none";
      document.getElementsByTagName("main")[0].style.paddingTop = "7rem";

      generateTable(xhr.responseText);
      generateHiddenForm();

      document.getElementById("form").style.display = "block";
      document.getElementById("form").style.padding = "0 3rem 0 3rem";
    }
  };
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
      '"/>' +
      '<input type="radio" name="status[' +
      student.roll_no +
      '][]" value="present" checked /> Present' +
      "&emsp;" +
      '<input type="radio" name="status[' +
      student.roll_no +
      '][]" value="absent" /> Absent';
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
    '"/>';
  form.appendChild(hiddenDiv);
}
