<?php 
namespace Jakobus;
/**
 * class_calendar.inc
 * Kalenderklasse: Erzeugt einen Kalender zur Datumsauswahl f�r Webseiten
 * @author J.Hahn
 * @version 2010-05-18
 */

class Calendar {
	
	public $daysInRow = 7;
	public $daysWithLink = array();
	public $monthNames = array(
		1 => 'Januar',
		2 => 'Februar',
		3 => 'M&auml;rz',
		5 => 'Mai',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'August',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Dezember'
	);
	
	public function __construct() {
		$this->month = intval(date('n'));
		$this->year = date('Y');
	
	}
	
	/**
	 * public function createCalendar($params=array())
	 * Erzeugt das HTML eines Kalenders
	 * 
	 * @param array $params Paramter werden in einem Array erwartet:
	 * string 'link' Link eines Datums, Angaben in {} werden mit passenden Werten ersetzt (default: '?year={YEAR}&amp;month={MONTH}&amp;day={DAY}') 
	 * string 'selectorDayLinked' CSS-Selektor: Verlinkter Tag (default: 'dayLinked')
	 * string 'selectorEmptyCell' CSS-Selektor: leere Zelle (default: 'emptyCell')
	 * string 'selectorDay' CSS-Selektor: leere Zelle (default: 'day')
	 * string 'selectorWeekendDay' CSS-Selektor: Wochenendtag (Sa oder So) (default: 'weekendDay')
	 * string 'selectorCalendar' CSS-Selektor: Kalender (default: 'calendar')
	 * string 'selectorRowNumber' CSS-Selektor: Reihe (Woche), (default: row{ROW}, wobei '{ROW}' durch Reihennummer ersetzt wird)
	 * string 'selectorToday' CSS-Selektor: aktuelles Datum (default: 'today')
	 * string 'selectorPastDay' CSS-Slektor: Bereits vergangene Tage (default: 'pastDay')
	 * string 'selectorFutureDay' CSS-Selektor: zuk�nftige Tage (default: 'futureDay')
	 * string 'calendarID' ID des Kalenders (default: '')
	 * string 'contentEmptyCell' Inhalt f�r leere Zellen (default: Leerzeichen)
	 * array 'dayNames' Wochentagnamen (default: array ('Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'))
	 * string 'formatDayNr' sprintf-Formatierung f�r ausgegebene Tagesdaten (default: '%02s')
	 * string 'year' Jahr des Kalenders im Format 2010 (default: aktuelles Jahr)
	 * string 'month' Monat des Kalenders (default: aktueller Montat)
	 * boolean 'linkPastDays' Falls 'true' werden auch abgelaufene Termine verlinkt
	 * string 'caption' set a table caption(e.g. month/year)
	 * 
	 * @return string HTML des Kalenders (Tabelle)
	 */
	public function createCalendar($params=array()) {
		
		$defaultParams = array(
			'link' => '?year={YEAR}&amp;month={MONTH}&amp;day={DAY}',
			'selectorDayLinked' => 'day-linked',
			'selectorEmptyCell' => 'empty-cell',	
			'selectorDay' => 'day',
			'selectorWeekendDay' => 'weekend-day',
			'selectorCalendar' => 'calendar',
			'selectorRowNumber' => 'row{ROW}',
			'selectorToday' => 'today',
			'selectorPastDay' => 'past-day',
			'selectorFutureDay' => 'future-day',
			'calendarID' => '',
			'contentEmptyCell' => ' ',
			'dayNames' => array ('Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'),
			'formatDayNr' => '%02s',
			'year' => '',
			'month' => '',
			'linkPastDays' => false,
			'caption' => false
		);
		$params = array_merge($defaultParams, $params);
		
		// Wurden Jahr und Monat �bergeben?
		if ($params['year']) {
			$this->year = $params['year'];
		}
		
		if ($params['month']) {
			$this->month = $params['month'];
		}
		
		// Variablen initialisieren
		$daysInMonth = $this->getDaysInMonth();
		$dayOfMonth = 1;
		$contentCalendar = '';
		$contentCalendarRow = '';
		$rowNr = 1;
		$currentYear = date('Y');
		$currentMonth = date('m');
		$currentDay = date('d');
		$today = date('Y-m-d');
		$mF = sprintf("%02s", $this->month);
		
		
		// Kalender-HTML erzeugen
		while ($dayOfMonth <= $daysInMonth && $c++ < 32 ) {
		
			// Reihen mit CSS-Selektor markieren
			if ($params['selectorRowNumber']) {
				$cssSelectorRow = str_replace('{ROW}', $rowNr, $params['selectorRowNumber']);
			}
			
			for ($i = 1; $i <= $this->daysInRow; $i++) {

				$cssSelectors = '';
				
				// Reihe mit CSS-Selektor markieren
				if ($cssSelectorRow) {
					$cssSelectors .= $cssSelectorRow; 
				}
				
				$weekDayOfMonth = date('N', mktime(0, 0, 0, intval($this->month), intval($dayOfMonth), intval($this->year)));
				$dayFormated = $dayOfMonth;
				
				// Ausgabe formatieren
				if ($params['formatDayNr']) {
					$dayFormated = sprintf($params['formatDayNr'], $dayFormated);
				}

			
				if ($weekDayOfMonth == $i && $dayOfMonth <= $daysInMonth) {
					
					$pastDay = false;					
					
					// Tag mit CSS-Selektor markieren
					$cssSelectors .= ' '.$params['selectorDay'];
					
					// Wochenenden mit CSS-Selektor markieren
					if ($i >= 6) {
						$cssSelectors .= ' '.$params['selectorWeekendDay'];
					}
					
					// Aktuellen Tag mit CSS-Selektor markieren
					if ($this->year.'-'.$mF.'-'.sprintf("%02s", $dayOfMonth) == $today) {
						$cssSelectors .= ' '.$params['selectorToday'];
					} else {

						// Vergangene oder zuk�nftige Tage mit CSS-Selektor markieren
						if (time() > strtotime($this->year .'-' . $this->month . '-' . $dayOfMonth)) {
							$cssSelectors .= ' '.$params['selectorPastDay'];
							$pastDay = true;
						} else {
							$cssSelectors .= ' '.$params['selectorFutureDay'];
						}
					}
					
					if (($pastDay && $params['linkPastDays'] && $this->daysWithLink[$dayOfMonth]) || (!$pastDay && $this->daysWithLink[$dayOfMonth])) {
						
						// if individual link is given, thenn use this individual link for the day
						if (is_array($this->daysWithLink[$dayOfMonth])){
						
							$link = $this->daysWithLink[$dayOfMonth]['url'];
							$title = $this->daysWithLink[$dayOfMonth]['title'];
							$class = $this->daysWithLink[$dayOfMonth]['class'];
							
						} 
						
						// else try to use the global link
						else if ($this->daysWithLink[$dayOfMonth]) {
							$link =	$params['link'];
							$title = '';
						}
						
						// no link for the day
						else  {
							$link = ''; //$this->daysWithLink[$dayOfMonth];
							$title = '';
						}
						
						// always replace date parts in link
						$link = str_replace(
							array('{YEAR}', '{MONTH}', '{DAY}'),
							array(
								$this->year,
								sprintf('%02d', $this->month),
								sprintf('%02d', $dayOfMonth)
							),
							$link
						);
						
						$title = htmlentities($title);
						
						$cssSelectors .= ' '.$params['selectorDayLinked'];
						$contentCalendarRow .=	'<td class="'.$cssSelectors.' day-has-link">' .
												'<a href="'.$link.'" data-balloon-pos="top" data-balloon-length="large" data-balloon="'.$title.'" title="'.$title.'" class="'.$class.'">'.$dayFormated.'</a>' .
												'</td>';
						//print_r($title);
						
					} else {
						$contentCalendarRow .=	'<td class="'.$cssSelectors.'">' .
												$dayFormated .
												'</td>';
					}
					$dayOfMonth++;
				} else {
					$contentCalendarRow .=	'<td class="'.$cssSelectors.' '.$params['selectorEmptyCell'].$selectorWeekendDay.'">' .
											$params['contentEmptyCell'] .
											'</td>';
				}
			}

			$contentCalendar .= '<tr>'.$contentCalendarRow.'</tr>';
			$contentCalendarRow = '';
			$rowNr++;
		}

		// $contentCalendar .= sprintf('<tr><td colspan="7">%u rows</td></tr>', $rowNr);
		// Make sure that the calendar has always the same nr of rows (6)
		if ($rowNr < 7) {
			$contentCalendar .= '<tr><td colspan="7">&nbsp;</td></tr>';
		}
		
		// Tabellenkopf erzeugen
		if (is_array($params['dayNames'])) {
			
			$calendarHead = '';
			foreach($params['dayNames'] as $key => $dayName) {
				if ($key >= 5) {
					$calendarHead .= '<th class="'.$params['selectorWeekendDay'].'">'.$dayName.'</th>';
				} else {
					$calendarHead .= '<th>'.$dayName.'</th>';
				}
			}
			$calendarHead = '<tr>'.$calendarHead.'</tr>';
		}
		
		// Tabellenattribute
		if ($params['calendarID']) {
			$calendarID = ' id="'.$params['calendarID'].'"';
		}

		$caption = (!empty($params['caption'])) ? '<caption>'.strftime($params['caption'], strtotime(sprintf('%04u-%02u', $this->year, $this->month))).'</caption>' : '';
		return '<table'.$calendarID.' class="'.$params['selectorCalendar'].'" data-year="'.$this->year.'" data-month="'.$this->month.'">' . $caption . '<thead>'.$calendarHead.'</thead><tbody>'.$contentCalendar.'</tbody></table>';
	}

	/**
	 * public function setDayWithLink()
	 * Setzt einen Tag auf Status "verlinkt"
	 * 
	 * @param number $day Tag des Datums (Zahl zwischen 1 und 31)
	 * @param string $link 
	 * 
	 * @return boolean 
	 */
	public function setDayWithLink($day, $link='') {
		if (!$day || $day > 31) return false;
		$this->daysWithLink[$day] = $link;
	}

	/**
	 * public function setDayWithLink()
	 * Setzt mehrere Tage auf Status "verlinkt"
	 * 
	 * @param array $days Tage als Tag => Link Array (Zahlen zwischen 1 und 31)
	 * 
	 * @return boolean 
	 */
	public function setDaysWithLink($days=array()) {
		
		if (!is_array($days)) return false;
		
		foreach ($days as $day => $link) {
			$this->daysWithLink[$day] = $link;
		}
		return true;
	}


	public function getCurrentMonthData($monthNr=0, $year=0) {
		if (!$monthNr) {
			$monthNr = intval($this->month);
		}
		$monthNr = intval($monthNr);

		if (!$year) {
			$year = intval($this->year);
		}
		
		if ($monthNr > 12 || $monthNr < 1) return array();
		
		$monthData = array (
			'currentMonthNr' => $monthNr,
			'currentMonthName' => $this->monthNames[$monthNr],
			'currentYear' => $this->year
		);
		return $monthData;
	}
	
	public function getPrevMonthData($monthNr=0, $year=0) {
		if (!$monthNr) {
			$monthNr = intval($this->month);
		}
		$monthNr = intval($monthNr);

		if (!$year) {
			$year = intval($this->year);
		}
		
		if ($monthNr > 12 || $monthNr < 1) return array();
		
		if ($monthNr == 1) {
			$monthNr = 12;
			$year -= 1;
		} else {
			$monthNr -= 1;
		}
		
		$monthData = array (
			'prevMonthNr' => $monthNr,
			'prevMonthName' => $this->monthNames[$monthNr],
			'prevYear' => $year
		);
		return $monthData;
	}

	public function getNextMonthData($monthNr=0, $year=0) {
		if (!$monthNr) {
			$monthNr = intval($this->month);
		}
		$monthNr = intval($monthNr);

		if (!$year) {
			$year = intval($this->year);
		}
		
		if ($monthNr > 12 || $monthNr < 1) return array();
		
		if ($monthNr == 12) {
			$monthNr = 1;
			$year += 1;
		} else {
			$monthNr += 1;
		}
		
		$monthData = array (
			'nextMonthNr' => $monthNr,
			'nextMonthName' => $this->monthNames[$monthNr],
			'nextYear' => $year
		);
		return $monthData;
	}
	
	public function setMonthNames($monthNames = array()) {
		
		if (!is_array($monthNames)) {
			return false;
		}
		
		$i = 1;
		
		foreach ($monthNames as $monthName) {
			$this->monthNames[$i++] = $monthName;
		}
		
		if ($i > 1) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * public function getDaysInMonth( 
	 * Ermittellt die tages eines Monats
	 * 
	 * @param number $month Monatszahl. Wird keine �bergeben, verwendet die Methode den aktuellen Monat
	 * @param number $year Jahreszahl. Wird keine �bergeben, verwendet die Methode das aktuelle Jahr
	 * 
	 * @return number Zahl der Tage im angeforderten Monat.
	 */
	public function getDaysInMonth($month=0, $year=0) {
		
		$month = intval($month);
		$year = intval($year);
		
		if (!$month) {
			$month = $this->month;
		}
		
		if (!$year) {
			$year = $this->year;
		}
		
		$timeStamp = mktime(0, 0, 0, (int)$month, 1, (int)$year);
		$daysInMonth = date('t', $timeStamp);
		
		return $daysInMonth;
	}
	
	public function getMonthName($month=0) {
		
		if (!intval($month)) {
			$month = intval(date('m'));
		}
		return $this->monthNames[intval($month)];
	}
}
?>
