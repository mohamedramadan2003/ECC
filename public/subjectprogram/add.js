$(document).ready(function() {
    $(".modal-effect").click(function(event) {
        event.preventDefault();
        var modalId = $(this).attr("href");
        var modal = new bootstrap.Modal(document.querySelector(modalId));
        modal.show();
    });
});
function confirmDelete(event) {
    event.preventDefault();

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: "لن يمكنك استعادة هذه المادة!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم، احذف!',
        cancelButtonText: 'إلغاء',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').submit();
        }
    });
}
