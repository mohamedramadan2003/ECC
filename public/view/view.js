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

  function addExam() {
  
  }
  function toggleDepartments(type) {
    
    document.getElementById("normal-departments").style.display = "none";
    document.getElementById("special-departments").style.display = "none";

    
    if (type === "normal") {
      document.getElementById("normal-departments").style.display = "block";
    } else if (type === "special") {
      document.getElementById("special-departments").style.display = "block";
    }
  }
  