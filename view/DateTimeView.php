<?php

class DateTimeView {


	public function show() {
		date_default_timezone_set("Europe/Stockholm");

		//source: http://php.net/manual/en/function.date.php
		$timeString = date("l, \\t\h\\e jS \of\ F Y, \T\h\\e \\t\i\m\\e \i\s H:i:s");

		return '<p>'. $timeString . '</p>';
	}
}