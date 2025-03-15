const formInputs = document.querySelectorAll("input, .level");
formInputs.forEach((input) => {
  input.addEventListener("input", updateQRCode);
});

function updateQRCode() {
  const subjectCode = document.getElementById("subject-code").value;
  const subjectName = document.getElementById("subject-name").value;
  const professorName = document.getElementById("professor-name").value;
  const examDate = document.getElementById("exam-date").value;

  const selectedLevels = Array.from(document.querySelectorAll(".level:checked"))
    .map((level) => level.value)
    .join(", ");

  if (!subjectCode && !subjectName && !professorName && !examDate) {
    document.getElementById("qr-code-container").innerHTML = ""; // Clear QR
    return;
  }

  const qrData = `
    كود المادة: ${subjectCode}
    اسم المادة: ${subjectName}
    دكتور المادة: ${professorName}
    موعد الاختبار: ${examDate}
    المستوى: ${selectedLevels}
  `;

  const qrCodeContainer = document.getElementById("qr-code-container");
  qrCodeContainer.innerHTML = "";
  QRCode.toCanvas(qrCodeContainer, qrData, (error) => {
    if (error) console.error(error);
  });
}

document.getElementById("exam-form").addEventListener("submit", (event) => {
  event.preventDefault();
  alert("تم تسليم البيانات بنجاح!");
});
function toggleDepartments(type) {
  // Hide both lists
  document.getElementById("normal-departments").style.display = "none";
  document.getElementById("special-departments").style.display = "none";

  // Show the selected list
  if (type === "normal") {
    document.getElementById("normal-departments").style.display = "block";
  } else if (type === "special") {
    document.getElementById("special-departments").style.display = "block";
  }
}
