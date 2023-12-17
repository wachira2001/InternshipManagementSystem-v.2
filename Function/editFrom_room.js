function showConfirmation() {
    // แสดง SweetAlert หรือโค้ดที่ใช้ในการยืนยันก่อนที่จะยกเลิก
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกการแก้ไขห้องเรียน',
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
            window.location.href = 'showdata_room.php';
        }
    });
}
function saveData(R_ID) {
    var R_level = document.getElementById('R_level').value;
    var R_level_number = document.getElementById('R_level_number').value;
    var R_room = document.getElementById('R_room').value;
    var T_ID = document.getElementById('T_ID').value;

    if ($.trim(R_level) === '' || $.trim(R_level_number) === '' || $.trim(R_room) === '' || $.trim(T_ID) === '') {
        Swal.fire({
            icon: 'error',
            title: 'กรุณากรอกข้อมูลห้องให้ครบ',
            showConfirmButton: true,
        });
        return;
    }

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
                url: '../../../teacher/services_teacher/update_room.php',
                data: {
                    R_ID: R_ID,
                    R_level: R_level,
                    R_level_number: R_level_number,
                    R_room: R_room,
                    T_ID: T_ID,
                },
                success: function (response) {
                    console.log(response);
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'แก้ไขข้อมูลห้องเรียนสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location.href = 'showdata_room.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูลห้องเรียน',
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
