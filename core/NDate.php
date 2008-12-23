<?php
/**
 * Norex Extended Date class
 * @author David Wolfe <wolfe@norex.ca>
 * @version 1.0
 */

/**
 * Norex Extended Date class
 * Extends functionality in Date class.
 * 
 * FOR SAMPLE CALLS SEE TESTS AT START OF class DEFINITION BELOW:
 * 
 * CONSTRUCTOR:
 *   A date can be specified in most common formats used in the CMS including a string, a timestamp,
 *   an array (as per calendar module), and any format acceptable to Date.
 *      new NDate([mixed $date1 = null], ...):
 *  $date2 can be another date specifier, in which case $date1 is relative to $date2.
 *    EXAMPLE: new NDate("last friday noon", "Nov 5, 2008")
 *  These can be changed to arbitrary length:
 *             new NDate("3:35pm", "1st", "Sep 20, 2008")
 * For string inputs, see http://www.gnu.org/software/automake/manual/tar/Date-input-formats.html
 * In addition, "1st" (or "first") and "last" are special case strings which mean
 *              1st of the month and last of the month, resp. 
 * 
 * PRIMARY ACCESSOR:
 *   $date->get([const $format = null]);
 * If $format is null, the get() returns the NDate itself.
 * If $format is a string, it's interpreted as per Pear Date->format() as described in 
 *    comment in PEAR/Date.php source.  It's darn close to PhP's strftime().
 * If $format is an integer, it can be one of the constants
 *   MYSQL_DATE			2008-09-05				
 *   MYSQL_TIME			15:15:34				
 *   MYSQL_DATETIME		2008-09-05 15:15:34			
 *   MYSQL_TIMESTAMP	2008-09-05 15:15:34
 *   TIME_FORMAT_AM_PM	3:15 PM
 *   TIME_FORMAT_am_pm	3:15 pm
 *   SLASHDATE_AM_PM    12/3/08 3:15 PM
 *   SLASHDATE_am_pm    12/3/08 3:15 pm
 
 * Inherited from PEAR's Date:
 *   DATE_FORMAT_ISO                    2008-09-05 15:15:34
 *   DATE_FORMAT_ISO_BASIC              20080905T151534
 *   DATE_FORMAT_ISO_EXTENDED           2008-09-05T15:15:34
 *   DATE_FORMAT_ISO_EXTENDED_MICROTIME 2008-09-05T15:15:34.000000
 *   DATE_FORMAT_TIMESTAMP              20080905151534
 *   DATE_FORMAT_UNIXTIME               1220638534
 */
require_once 'Date.php';

// Choosing high numbers to distinguish from PEAR's Date.
define ('MYSQL_DATE', 101);
define ('MYSQL_TIME', 102);
define ('MYSQL_DATETIME', 103);
define ('MYSQL_TIMESTAMP', 104);
define ('TIME_FORMAT_AM_PM', 105);
define ('TIME_FORMAT_am_pm', 106);
define ('SLASH_DATE_AM_PM', 107);
define ('SLASH_DATE_am_pm', 108);
class NDate extends Date {
	static function test() {
		$a = new NDate("12:30am");
		$b = new NDate(array ('h'=>12, 'i'=>30, 'a'=>'am'));
		error_log ("TESTING STARTED");
		// test2(a,b)   calls NDate(a) and NDate(b) and checks for equality
		// test2(a,b,c) calls NDate(a) and NDate(b,c)
		// test2(a,b,c,d) calls NDate(a) and NDate(b,c,d)
		NDate::test2 ("12:30am", array ('h'=>12, 'i'=>30, 'a'=>'am'));
		NDate::test2 ("12:30pm", array ('h'=>12, 'i'=>30, 'a'=>'pm'));
		NDate::test2 ("12:00AM", array ('h'=>12, 'i'=>0, 'a'=>'AM'));
		NDate::test2 ("12:00PM", array ('h'=>12, 'i'=>0, 'A'=>'PM'));
		NDate::test2 ("12:00pm", array ('h'=>12, 'i'=>0, 'a'=>'pm'));
		NDate::test2 ("11:55am", array ('h'=>11, 'i'=>55, 'a'=>'am'));
		NDate::test2 ("11:55pm", array ('h'=>11, 'i'=>55, 'a'=>'pm'));
		NDate::test2 ("Sep 2, 2008 noon", "yesterday noon", "Sep 3, 2008");
		NDate::test2 ("Sep 1, 2008", "1st", "Sep 20, 2008");
		NDate::test2 ("Sep 30, 2008", "last", "Sep 20, 2008");
		NDate::test2 ("Sep 1, 2008 3:35pm", "3:35pm", "1st", "Sep 20, 2008");
		error_log ("TESTING DONE");
	}

	function NDate($date = null, $now = null) {
		$n = func_num_args();
		$p = ($n == 3);
		$args = func_get_args();
    	$this->tz = Date_TimeZone::getDefault();
    	if ($n == 0) {return parent::Date();}
    	
    	$n--;
		$date = $args[$n];
    	if (is_array ($date)) {
			$this->setDate($date);
    	} elseif (is_int ($date) || (is_string ($date) && (string) (integer) $date == (string) $date)
    			&& ($date < 9876543210)
    			&& ($date > 0123456789)) {
    			// Looks like a UNIX timestamp
    		parent::Date($date);
		} elseif (is_string ($date)) {
			$this->setDate (strtotime($date));
		} else {
			parent::Date($date); 
		}
		while ($n > 0) {
			$n--;
			$now = $this->getDate(DATE_FORMAT_UNIXTIME);
			$date = $args[$n];
			switch ($date) {
				case "1st":
				case "first":
					$this->setDay(1); 
					break;
				case "last": 
					$this->setDay($this->getDaysInMonth()); 
					break;
				default:
					$this->setDate(strtotime ($date, $now));
			}
		}
	}

	function setDate($date, $format = DATE_FORMAT_ISO) {
		if (is_array($date)) {
			$this->setDateArray($date);
			return;
		}
		if (is_int($format) && $format < 100) {
			parent::setDate($date, $format);
			return;
		}
		if ($this->getDate() == "0-01-01 00:00:00") {
			$date = strtotime ($date);
			parent::setDate($date);
		}
	}

	function get($format = null) {
		if (is_null ($format)) return $this;
		if (is_string ($format) && defined ($format)) {eval("\$format= $format;");} // PERMITS USE OF 'MYSQL_TIMESTAMP'
		if (is_int ($format)) return $this->getDate($format);
		if (is_string ($format)) return $this->format($format);
	}
	
	function getDate($format = null) {
		if (is_null($format)) return parent::getDate();
		switch ($format) {
			case MYSQL_DATE: return $this->format3 ("Y-m-d");
			case MYSQL_TIME: return $this->format3 ("H:i:s");
			case MYSQL_DATETIME: return $this->format3 ("Y-m-d H:i:s");
            case MYSQL_TIMESTAMP: return parent::getDate(DATE_FORMAT_ISO);
			case TIME_FORMAT_AM_PM: return $this->format3 ("g:i A");
            case TIME_FORMAT_am_pm: return $this->format3 ("g:i a");
			case SLASH_DATE_AM_PM: return $this->format3 ("n/j/y g:iA");
            case SLASH_DATE_am_pm: return $this->format3 ("n/j/y g:ia");
            default: return parent::getDate($format); 
		}
	}

	private function setDateArray ($date) {
		$this->setDate(date("Y-m-d H:i:s")); // unspecified values default to current time.
		foreach ($date as $key => $value) {
			// If something in specified, clear everything thereafter.
			switch ($key) {
				case 'Y': $this->setYear(0);
				case 'n':
				case 'M':
				case 'F': // NOT DONE
				case 'm': $this->setMonth(0);
				case 'j':
				case 'd': $this->setDay(0);
				case 'H':
				case 'g':
				case 'h':
				case 'a':
				case 'A': $this->setHour(0);
				case 'i': $this->setMinute(0);
				case 's': $this->setSecond(0); break;
				default: error_log ("Key unrecognized in setDate: " . $key);
			}
		}
		foreach ($date as $key => $value) {
			$pm = false;
			switch ($key) {
				case 'Y': $this->setYear($value); break;
				case 'n':
				case 'M':
				case 'm': $this->setMonth($value); break;
				case 'j':
				case 'd': $this->setDay($value); break;
				case 'H': $this->setHour($value); break;
				case 'g': // pass through
				case 'h': $this->setHour($value % 12); break;
				case 'a': // pass through
				case 'A': if (strtolower($value) == 'pm') $pm = true; break;
				case 'i': $this->setMinute($value); break;
				case 's': $this->setSecond($value); break;
				default: error_log ("Key unrecognized in setDate: " . $key);
			}
		}
		if ($pm) $this->addSeconds (60 * 60 * 12);
		return;
	}
	
	static function test2 ($a, $b, $c = NULL, $d = NULL) {
		$a1 = new NDate($a);
		$b1 = ($d ? new NDate($b, $c, $d) :
			   ($c ? new NDate ($b, $c) :
			   new NDate ($b))); 
		if ($a1->equals($b1)) return;
		error_log ("----- TEST FAILED ----- ");
		var_log ($a);
		var_log ($b);
		if (isset ($c)) var_log ($c);
		if (isset ($d)) var_log ($d);
		var_log ($a1->get(MYSQL_DATETIME));
		var_log ($b1->get(MYSQL_DATETIME));
		error_log ("----------------------- ");
		
	}
	
	public function __toString() {
		return $this->getDate();
	}
}
// NDate::test();
?>
