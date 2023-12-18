function Approved(request_id) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'คำร้องนี้จะถูกอนุมัติ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var RE_commentH = 'อนุมัติคำร้อง';
            var RE_teacherH_opinion = '1';
            var RE_status = '2';
            $.ajax({
                type: 'POST',
                url: '../../services_teacher/update_request.php',
                data: {
                    request_id: request_id,
                    RE_commentH: RE_commentH,
                    RE_teacherH_opinion: RE_teacherH_opinion,
                    RE_status : RE_status
                },
                success: function (response) {
                    // console.log(response);
                    // return;
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'อนุมัติคำร้องสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            window.location.href = 'showdata_request.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'เกิดข้อผิดพลาดในการอนุมัติคำร้อง',
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

//ไม่อนุมัติคำร้อง
function NOTApproved(request_id) {
    // var RE_commentH = $('[name="RE_commentH"]').val();
    var RE_commentH = $('#RE_commentH' + request_id).val();
    var RE_teacherH_opinion = '0'
    var RE_status = '0'; // 0= ไม่ผ่านการอนุมัติ หัวหน้าแผนกไม่อนุมัติจะไม่ถึงให้ครูที่ปรึกษาอนุมัติ
    // ตรวจสอบว่า RE_commentH ไม่เป็นค่าว่างหรือไม่
    if (RE_commentH.trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'กรุณากรอกเหตุผลไม่อนุมัติคำร้อง',
            showConfirmButton: true,
        });
        return;
    }


    $.ajax({
        type: 'POST',
        url: '../../services_teacher/update_request.php',
        data: {
            request_id: request_id,
            RE_commentH: RE_commentH,
            RE_status: RE_status,
            RE_teacherH_opinion: RE_teacherH_opinion
        },

        success: function (response) {
            if (response === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'ไม่อนุมัติคำร้อง สำเร็จ',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = 'showdata_request.php';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาดในการไม่อนุมัติคำร้อง เนื่องจากเกิดข้อผิดพลาดบางอย่าง',
                    text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                });
            }
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาดในการไม่อนุมัติคำร้อง ',
                text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
            });
        }
    });
}
// ยกเลิกไม่อนุมัติคำร้อง/ยกเลิกอนุมัติ
function Cancel(request_id) {
    // สร้าง Popup ถามยืนยัน
    Swal.fire({
        title: 'ยืนยันการยกเลิกไม่อนุมัติคำร้อง',
        text: 'คุณต้องการที่จะยกเลิกไม่อนุมัติคำร้องนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        // ถ้าผู้ใช้กด OK (ยืนยัน)
        if (result.isConfirmed) {
            // ทำการส่งค่าผ่าน Ajax
            var RE_commentH = '';
            var RE_teacherH_opinion = '';
            var RE_status = '1'; // 0= ไม่ผ่านการอนุมัติ หัวหน้าแผนกไม่อนุมัติจะไม่ถึงให้ครูที่ปรึกษาอนุมัติ
            console.log({
                request_id: request_id,
                RE_commentH: RE_commentH,
                RE_status: RE_status,
                RE_teacherH_opinion: RE_teacherH_opinion
            });
            $.ajax({
                type: 'POST',
                url: '../../services_teacher/update_request.php',
                data: {
                    request_id: request_id,
                    RE_commentH: RE_commentH,
                    RE_status: RE_status,
                    RE_teacherH_opinion: RE_teacherH_opinion
                },
                success: function (response) {
                    // การจัดการผลลัพธ์
                    // console.log(response);
                    // return;
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ยกเลิก สำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'showdata_request.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถยกเลิกไม่อนุมัติคำร้องได้',
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
    });
}
//โชว์คอนเพิม
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
            window.location.href = 'showdata_request.php';
        }
    });
}