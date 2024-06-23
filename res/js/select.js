function filterSemestersAccordingToProgram() {
  const programSelect = document.getElementById("program");
  const semesterSelect = document.getElementById("semester");
  const sectionSelect = document.getElementById("section");
  const subjectSelect = document.getElementById("subject");
  const selectedProgram = programSelect.value;

  semesterSelect.innerHTML = '<option value="">Select semester</option>';
  sectionSelect.innerHTML = '<option value="">Select section</option>';
  subjectSelect.innerHTML = '<option value="">Select subject</option>';

  if (selectedProgram) {
    const semesters = classes
      .filter((cls) => cls.program === selectedProgram)
      .map((cls) => cls.semester);
    const uniqueSemesters = [...new Set(semesters)];

    uniqueSemesters.sort((a, b) => a - b);

    uniqueSemesters.forEach((semester) => {
      const option = document.createElement("option");
      option.value = semester;
      option.text = semester;
      semesterSelect.appendChild(option);
    });

    semesterSelect.disabled = false;
  } else {
    semesterSelect.disabled = true;
  }
}

function filterSectionsAccordingToSemester() {
  const programSelect = document.getElementById("program");
  const semesterSelect = document.getElementById("semester");
  const sectionSelect = document.getElementById("section");
  const subjectSelect = document.getElementById("subject");
  const selectedProgram = programSelect.value;
  const selectedSemester = parseInt(semesterSelect.value, 10);

  sectionSelect.innerHTML = '<option value="">Select section</option>';
  subjectSelect.innerHTML = '<option value="">Select subject</option>';

  if (selectedProgram && !isNaN(selectedSemester)) {
    const sections = classes
      .filter(
        (cls) =>
          cls.program == selectedProgram && cls.semester == selectedSemester
      )
      .map((cls) => cls.section);
    const uniqueSections = [...new Set(sections)];

    uniqueSections.sort((a, b) => a - b);

    uniqueSections.forEach((section) => {
      const option = document.createElement("option");
      option.value = section;
      option.text = section;
      sectionSelect.appendChild(option);
    });

    sectionSelect.disabled = false;
  } else {
    sectionSelect.disabled = true;
  }
}

function filterSubjectsAccordingToSection() {
  const programSelect = document.getElementById("program");
  const semesterSelect = document.getElementById("semester");
  const sectionSelect = document.getElementById("section");
  const subjectSelect = document.getElementById("subject");
  const selectedProgram = programSelect.value;
  const selectedSemester = parseInt(semesterSelect.value, 10);
  const selectedSection = sectionSelect.value;

  subjectSelect.innerHTML = '<option value="">Select subject</option>';

  if (selectedProgram && !isNaN(selectedSemester) && selectedSection) {
    const subjects = classes
      .filter(
        (cls) =>
          cls.program == selectedProgram &&
          cls.semester == selectedSemester &&
          cls.section == selectedSection
      )
      .map((cls) => ({
        subject_code: cls.subject_code,
        subject_title: cls.subject_title,
      }));
    const uniqueSubjects = [
      ...new Set(subjects.map((s) => JSON.stringify(s))),
    ].map((s) => JSON.parse(s));

    uniqueSubjects.forEach((subject) => {
      const option = document.createElement("option");
      option.value = subject.subject_code;
      option.text = subject.subject_title;
      subjectSelect.appendChild(option);
    });

    subjectSelect.disabled = false;
  } else {
    subjectSelect.disabled = true;
  }
}
