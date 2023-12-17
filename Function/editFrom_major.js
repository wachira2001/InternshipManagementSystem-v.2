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
    $('#FormEditMajor').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        Swal.fire({
            title: 'คุณต้องการบันทึกการแก้ไข ใช่หรือไม? ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../../services_teacher/edit_major.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // console.log(response);
                        // return;
                        if (response.trim() === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'แก้ไขข้อมูลแผนกสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                window.location.href = 'showdata_major.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูลแผนก',
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


function showConfirmation() {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกการแก้ไขข้อมูลแผนก',
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
            window.location.href = '../../../config/logout.php';
        }
    });
}
