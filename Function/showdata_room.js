function deleteUser(R_ID) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบ!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteUserData(R_ID);
        }
    });
}
function Delete(R_ID) {
    Swal.fire({
        title: 'คุณต้องการลบ ใช่หรือไม่?',
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
                url: '../../services_teacher/delete_room.php',
                data: { R_ID: R_ID },
                success: function (response) {
                    console.log(response);

                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location.href = 'showdata_room.php';
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
function showConfirmation() {
    // แสดง SweetAlert หรือโค้ดที่ใช้ในการยืนยันก่อนที่จะยกเลิก
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'การกระทำนี้จะยกเลิกขั้นตอนที่คุณทำ',
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
function saveData() {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'ที่จะบันทึกการแก้ไขข้อมูล',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่, บันทึก!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.querySelector('#insert').submit();
        }
    });
}
function Addroom() {
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

    $.ajax({
        type: 'POST',
        url: '../../services_teacher/insert_room.php',
        data: {
            R_level: R_level,
            R_level_number: R_level_number,
            R_room: R_room,
            T_ID: T_ID,
        },

        success: function (response) {
            // การจัดการผลลัพธ์
            console.log(response);
            if (response === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'เพิ่มข้อมูลห้องสำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // window.location.href = 'showdata_room.php';
                    location.reload();
                });
            } else if (response === 'duplicate') {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการเพิ่มห้องเรียน',
                    text: 'อาจารย์ท่านนี้มีการเข้าสอนห้องอื่นแล้ว',
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล',
                    text: response
                });
            }
        },

        error: function (xhr, status, error) {
            // การจัดการข้อผิดพลาดจาก Ajax
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'ไม่สามารถยกเลิกไม่อนุมัติคำร้องได้',
            });
        }
    });
}