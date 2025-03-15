
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
