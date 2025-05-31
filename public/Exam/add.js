function toggleDepartments(type, clickedBtn) {
  // Hide both lists
  document.getElementById("normal-departments").style.display = "none";
  document.getElementById("special-departments").style.display = "none";

  // Show the selected list
  if (type === "normal") {
    document.getElementById("normal-departments").style.display = "block";
  } else if (type === "special") {
    document.getElementById("special-departments").style.display = "block";
  }

  // إزالة الكلاس 'active' من كل الأزرار في نفس المجموعة
  const buttons = clickedBtn.parentNode.querySelectorAll("button");
  buttons.forEach(btn => btn.classList.remove("active"));

  // إضافة الكلاس 'active' للزر اللي اتضغط عليه
  clickedBtn.classList.add("active");
}
