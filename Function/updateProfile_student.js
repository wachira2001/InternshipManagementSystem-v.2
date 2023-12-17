// window.location.href = '../teacher/services_teacher/INSERT_teacher.php'



document.getElementById('imageInput').addEventListener('change', function (e) {
    var preview = document.getElementById('previewImage');
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "#";
    }
});

// เมื่อกดปุ่ม "บันทึก" หรือ "อัพโหลดใหม่"
function saveImage() {
    // ส่งข้อมูลรูปภาพไปยังเซิร์ฟเวอร์
    // ทำการอัพเดทในฐานข้อมูล
    // หลังจากอัพเดทสำเร็จ, ทำการแทนที่รูปภาพเก่าด้วยรูปภาพใหม่
    document.getElementById('currentImage').src = document.getElementById('previewImage').src;
}


$(document).ready(function () {
    $('#FormProfile').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        Swal.fire({
            title: 'คุณต้องการบันทึการแก้ไข ใช่หรือไม? ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../services_student/update_profile.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        if (response.trim() === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'แก้ไขข้อมูลส่วนตัวสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                location.reload(true);
                                window.location.href = 'editFrom_profile.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูลส่วนตัว',
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
        title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกการแก้ไขข้อมูลส่วนตัว',
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
function showConfirmationLogout() {
    // แสดง SweetAlert หรือโค้ดที่ใช้ในการยืนยันก่อนที่จะยกเลิก
    Swal.fire({
        title: 'คุณแน่ใจหรือไม ?',
        text: 'ออกจากระบบ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ออกจากระบบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // กระทำเมื่อยืนยัน
            window.location.href = '../../config/logout.php';
        }
    });
}
