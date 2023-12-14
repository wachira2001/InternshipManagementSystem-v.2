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


// Loading
$(function() {
	$("#loading-wrapper").fadeOut(1000);
});


// Toggle sidebar
$("#toggle-sidebar").on('click', function () {
	$(".page-wrapper").toggleClass("toggled");
});


// Toggle sidebar togglescreen
$("#sidebar-togglescreen").on('click', function () {
	$(".page-wrapper.togglescreen").toggleClass("toggled-togglescreen");
});


// Sidebars JS
jQuery(function ($) {

	$(".sidebar-dropdown > a").on('click', function () {
		$(".sidebar-submenu").slideUp(200);
		if ($(this).parent().hasClass("active")) {
			$(".sidebar-dropdown").removeClass("active");
			$(this).parent().removeClass("active");
		} else {
			$(".sidebar-dropdown").removeClass("active");
			$(this).next(".sidebar-submenu").slideDown(200);
			$(this).parent().addClass("active");
		}
	});

	

	// Added by Srinu 
	$(function(){
		// When the window is resized, 
		$(window).resize(function(){
			// When the width and height meet your specific requirements or lower
			if ($(window).width() <= 768){
				$(".page-wrapper").removeClass("pinned");
			}
		});
		// When the window is resized, 
		$(window).resize(function(){
			// When the width and height meet your specific requirements or lower
			if ($(window).width() >= 768){
				$(".page-wrapper").removeClass("toggled");
			}
		});
	});

});


// Toggle graph day selection
$(function() {
	$(".graph-day-selection .btn").on('click', function () {
		$(".graph-day-selection .btn").removeClass("active");
		$(this).addClass("active");   
	});
});


// Download File
$('.download-reports').on('click', function () {
	$.ajax({
		url: 'sample.txt',
		crossOrigin: null,
		xhrFields: {
		responseType: 'blob'
		},
		success: function(blob) {
		console.log(blob.size);
		var link = document.createElement('a');
		link.href = window.URL.createObjectURL(blob);
		link.download = "Reports" + ".txt";
		link.click();
		}
	});
});


// Todays Date
$(function() {
	var interval = setInterval(function() {
		var momentNow = moment();
		$('.todaysDate').html(momentNow.format('LLLL'));
	}, 100);
});



// Toggle Pricing Plan
$(".pricing-change-plan a").on('click', function () {
	if ($(this).hasClass("active-plan")) {
	  $(".pricing-change-plan a").removeClass("active-plan");
	}
	else {
	  $(".pricing-change-plan a").removeClass("active-plan");
	  $(this).addClass("active-plan");
	}
});


/***********
***********
***********
	Bootstrap JS 
***********
***********
***********/

// Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
})

// Popover
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
	return new bootstrap.Popover(popoverTriggerEl)
})