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


$(document).ready(function () {
    $('#FormEditCompany').on('submit', function (e) {
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
                    url: '../../../teacher/services_teacher/update_company.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // console.log(response);
                        // return;
                        if (response.trim() === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'แก้ไขสำเร็จ',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                window.location.href = 'showdata_company.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาดในการแก้ไข',
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
        title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกแก้ไขข้อมูล',
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
            window.location.href = 'showdata_company.php';
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

function Delete(company_ID) {
    Swal.fire({
        title: 'คุณต้องการลบ ใช่หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        console.log(company_ID);
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: '../../../teacher/services_teacher/delete_company.php',
                data: { company_ID: company_ID },
                success: function (response) {
                    console.log(response);
                    return;
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location.href = 'showdata_company.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'เกิดข้อผิดพลาดในการลบ',
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
}
