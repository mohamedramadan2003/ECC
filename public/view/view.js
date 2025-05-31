

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
