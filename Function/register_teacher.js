// window.location.href = '../teacher/services_teacher/INSERT_teacher.php'
$(document).ready(function () {
    $('#Formteacher').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: '../teacher/services_teacher/INSERT_teacher.php',
            data: formData,
            contentType: false, // ไม่ระบุประเภทข้อมูล
            processData: false, // ไม่แปลงข้อมูล
            success: function (response) {
                console.log(response);
                if (response.trim() === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลงทะเบียนสำเร็จ',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        window.location.href = '../login.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เกิดข้อผิดพลาดในการลงทะเบียน',
                        text: response
                    });
                }
            },
            error: function (error) {
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                    text: 'โปรดลองอีกครั้ง'
                });
            }
        });
    });
});



function Password() {
    var passwordInput = document.getElementById('password');
    var eyeIcon = document.getElementById('eye-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    }
}

function showConfirmation() {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกการสมัครสมาชิก',
        // text: 'การกระทำนี้จะยกเลิกขั้นตอนที่คุณทำ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ยกเลิก!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // กระทำเมื่อยืนยัน
            window.location.href = '../index.php';
        }
    });
}
