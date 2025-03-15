// تحديث التاريخ تلقائيًا في أعلى الصفحة
function updateDate() {
    const dateContainer = document.getElementById("current-date");
    const currentDate = new Date();
  
    const options = {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    };
  
    dateContainer.textContent = currentDate.toLocaleDateString("ar-EG", options);
  }
  
  updateDate();
  // طباعة الصفحة

  // إضافة امتحان جديد (وظيفة مبدئية)
  function addExam() {
  
  }
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
  