<?php
$ical = "BEGIN:VCALENDAR\r\n";
$ical .= "VERSION:2.0\r\n";
$ical .= "PRODID:-//TRUENORTH//Calendar//EN\r\n";
foreach ($iCalObjs as $item => $val) {
	//pr($val);
	if($val["user_id"] != $assignedTo) continue;
	
	$type = $G->ids->type($item);
	if (isset($val['start'])){
		$ical .= "BEGIN:VEVENT\r\n";
		$ical .= "DTSTAMP;VALUE=DATE-TIME:".date("Ymd\THis", $val['start'])."Z\r\n";
		$ical .= "DTSTART;VALUE=DATE-TIME:".date("Ymd\THis", $val['start'])."Z\r\n";
		$ical .= "DTEND;VALUE=DATE-TIME:".date("Ymd\THis", $val['start'])."Z\r\n";
		$ical .= "SUMMARY:".$type." - Start\r\n";
		$ical .= "DESCRIPTION:".$val['description']."\r\n";
		$ical .= "UID:".$val['id'].md5("Start")."\r\n";
		$ical .= "END:VEVENT\r\n";
		$ical .= "BEGIN:VEVENT\r\n";
		$ical .= "DTSTAMP;VALUE=DATE-TIME:".date("Ymd\THis", $val['start'])."Z\r\n";
		$ical .= "DTSTART;VALUE=DATE-TIME:".date("Ymd\THis", $val['due'])."Z\r\n";
		$ical .= "DTEND;VALUE=DATE-TIME:".date("Ymd\THis", $val['due'])."Z\r\n";
		$ical .= "SUMMARY:".$type." - Due\r\n";
		$ical .= "DESCRIPTION:".$val['description']."\r\n";
		$ical .= "UID:".$val['id'].md5("Due")."\r\n";
		$ical .= "END:VEVENT\r\n";
	} else {
		$ical .= "BEGIN:VEVENT\r\n";
		$ical .= "DTSTAMP;VALUE=DATE-TIME:".date("Ymd\THis", $val['due'])."Z\r\n";
		$ical .= "DTSTART;VALUE=DATE-TIME:".date("Ymd\THis", $val['due'])."Z\r\n";
		$ical .= "DTEND;VALUE=DATE-TIME:".date("Ymd\THis", $val['due'])."Z\r\n";
		$ical .= "SUMMARY:".$type." - Due\r\n";
		$ical .= "DESCRIPTION:".$val['description']."\r\n";
		$ical .= "UID:".$val['id'].md5("Due")."\r\n";
		$ical .= "END:VEVENT\r\n";
	}
}
$ical .= "END:VCALENDAR";
/*
$ical = "BEGIN:VCALENDAR\r\n";
$ical .= "METHOD:PUBLISH\r\n";
$ical .= "VERSION:2.0\r\n";
$ical .= "PRODID:-//Thomas Multimedia//Clinic Time//EN\r\n";
$ical .= "BEGIN:VEVENT\r\n";
$ical .= "SUMMARY:Emily Henderson\r\n";
$ical .= "UID:xxxxxxxxxxxxxxxxxxxxx\r\n";
$ical .= "STATUS:CONFIRMED\r\n";
$ical .= "DTSTAMP:20131231T031500Z\r\n";
$ical .= "DTSTART:20131231T031500Z\r\n";
$ical .= "DTEND:20140102T033000Z\r\n";
$ical .= "END:VEVENT\r\n";
$ical .= "END:VCALENDAR\r\n";
*/
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename=calendar.ics');
echo $ical;
