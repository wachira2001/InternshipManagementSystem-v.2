// window.location.href = '../student/services_student/INSERT_student.php'





function saveDataRequest(company_ID) {
    var form = $('#form-' + company_ID);
    var formData = new FormData(form[0]);

    Swal.fire({
        title: 'คุณต้องการยื่นคำร้อง ใช่หรือไม่? ',
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
                url: '../services_student/insert_request.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ยื่นคำร้องสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location.href = 'addFrom_request.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'เกิดข้อผิดพลาดในการยื่นคำร้อง',
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




function showConfirmation() {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกยื่นคำร้อง',
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
            window.location.href = 'addFrom_request.php';
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
