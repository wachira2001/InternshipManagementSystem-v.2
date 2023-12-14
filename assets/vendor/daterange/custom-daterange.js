// Date Range
$('.datepicker').daterangepicker({
	singleDatePicker: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY'
  }
});



// Date Range Opens Left
$('.datepicker-opens-left').daterangepicker({
	singleDatePicker: true,
	opens: 'left',
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY'
  }
});



$('.datepicker-week-numbers').daterangepicker({
	singleDatePicker: true,
	showWeekNumbers: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY'
  }
});



$('.datepicker-iso-week-numbers').daterangepicker({
	singleDatePicker: true,
	showISOWeekNumbers: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY'
  }
});



$('.datepicker-time').daterangepicker({
	singleDatePicker: true,
	timePicker: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY hh:mm A'
  }
});



$('.datepicker-time-24').daterangepicker({
	drops: 'up',
	singleDatePicker: true,
	timePicker: true,
	timePicker24Hour: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY hh:mm A'
  }
});



$('.datepicker-time-seconds').daterangepicker({
	drops: 'up',
	singleDatePicker: true,
	timePicker: true,
	timePicker24Hour: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY hh:mm:ss A'
  }
});



$('.datepicker-range').daterangepicker({
	drops: 'up',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



$('.datepicker-range-week-numbers').daterangepicker({
	drops: 'up',
	showWeekNumbers: true,
	opens: 'left',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



$('.datepicker-range-iso-week-numbers').daterangepicker({
	drops: 'up',
	opens: 'left',
	showWeekNumbers: true,
	showISOWeekNumbers: true,
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



$('.datepicker-range-time').daterangepicker({
	drops: 'up',
	timePicker: true,
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY hh:mm A'
  }
});


$('.datepicker-range-time-24').daterangepicker({
	drops: 'up',
	timePicker: true,
	timePicker24Hour: true,
	opens: 'left',
  startDate: moment().startOf('hour'),
  endDate: moment().startOf('hour').add(32, 'hour'),
  locale: {
    format: 'DD/MM/YYYY hh:mm A'
  }
});



$('.datepicker-range-left').daterangepicker({
	opens: 'left',
	drops: 'up',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



$('.datepicker-range-right').daterangepicker({
	opens: 'right',
	drops: 'up',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



$('.datepicker-range-top-right').daterangepicker({
	opens: 'right',
	drops: 'up',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



$('.datepicker-range-top-left').daterangepicker({
	opens: 'left',
	drops: 'up',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY'
	}
});



// Date Range Auto Apply
$('.datepicker-range-auto-apply').daterangepicker({
	autoApply: true,
	drops: 'up',
	opens: 'left',
	startDate: moment().startOf('hour'),
	endDate: moment().startOf('hour').add(32, 'hour'),
	locale: {
		format: 'DD/MM/YYYY',
		daysOfWeek: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
		monthNames: [
			'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
			'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
		]
	},
	isInvalidDate: function (date) {
		// ไม่ให้เลือกวันย้อนหลัง
		return date.isBefore(moment().startOf('day'));
	}
});

// Custom Date Range 1
$(function() {
	var start = moment().subtract(29, 'days');
	var end = moment();
	function cb(start, end) {
		$('.custom-daterange span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
	}
	$('.custom-daterange').daterangepicker({
		opens: 'left',
		startDate: start,
		endDate: end,
		ranges: {
			'วันนี้': [moment(), moment()],
			'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 วันที่ผ่านมา': [moment().subtract(6, 'days'), moment()],
			'30 วันที่ผ่านมา': [moment().subtract(29, 'days'), moment()],
			'เดือนที่แล้ว': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		isInvalidDate: function (date) {
			// ไม่ให้เลือกวันย้อนหลัง
			return date.isBefore(moment().startOf('day'));
		}
	}, cb);
	cb(start, end);
});

// Custom Date Range 2
$(function() {
	var start = moment().subtract(29, 'days');
	var end = moment();
	function cb(start, end) {
		$('.custom-daterange2 span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
	}
	$('.custom-daterange2').daterangepicker({
		autoApply: true,
		opens: 'left',
		startDate: start,
		endDate: end,
		ranges: {
			'วันนี้': [moment(), moment()],
			'เมื่อวาน': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 วันที่ผ่านมา': [moment().subtract(6, 'days'), moment()],
			'30 วันที่ผ่านมา': [moment().subtract(29, 'days'), moment()],
			'เดือนที่แล้ว': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		isInvalidDate: function (date) {
			// ไม่ให้เลือกวันย้อนหลัง
			return date.isBefore(moment().startOf('day'));
		}
	}, cb);
	cb(start, end);
});
