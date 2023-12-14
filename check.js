// กำหนดฟังก์ชันชื่อ togglePasswordVisibility
function togglePasswordVisibility() {
    // ดึงอิลิเมนต์ DOM ที่มี id "password" และเก็บไว้ในตัวแปร passwordField
    var passwordField = document.getElementById("password");

    // ดึงอิลิเมนต์ DOM ที่มี id "eye-icon" และเก็บไว้ในตัวแปร eyeIcon
    var eyeIcon = document.getElementById("eye-icon");

    // ตรวจสอบว่าแอตทริบิวต์ type ของฟิลด์รหัสผ่านในปัจจุบันตั้งค่าเป็น "password" หรือไม่
    if (passwordField.type === "password") {
        // ถ้าใช่, เปลี่ยนแอตทริบิวต์ type เป็น "text" (เปิดเผยรหัสผ่าน)
        passwordField.type = "text";

        // ลบคลาส "bi-eye" ออกจากไอคอนตา และเพิ่มคลาส "bi-eye-slash"
        eyeIcon.classList.remove("bi-eye");
        eyeIcon.classList.add("bi-eye-slash");
    } else {
        // ถ้าแอตทริบิวต์ไม่ได้เป็น "password" (เป็นไปได้ว่าเป็น "text"), เปลี่ยนกลับเป็น "password"
        passwordField.type = "password";

        // ลบคลาส "bi-eye-slash" ออกจากไอคอนตา และเพิ่มคลาส "bi-eye"
        eyeIcon.classList.remove("bi-eye-slash");
        eyeIcon.classList.add("bi-eye");
    }
}
function cancelAction() {
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
            console.log('Cancel action');
        }
    });
}
function submitForm() {
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
            console.log('Submit form action');
        }
    });
}
function myFunction() {
    let x = document.getElementById("myDate").max = "2015-01-01";
    document.getElementById("demo").innerHTML = "กรุณาป้อนอยู่ระหว่าง  '1950-01-01' to '2015-01-01'.";
}
