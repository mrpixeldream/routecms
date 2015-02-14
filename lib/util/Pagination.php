<?php

/*--------------------------------------------------------------------------------------------------
Datei      		 : Pagination.php
Beschreibung 	 : Klasse für die Seiten Funktionen
Copyright  		 : Routecms © 2015
Author 		     : Olaf Braun
Letzte Änderung  : 01.01.2015 Olaf Braun
-------------------------------------------------------------------------------------------------*/

class Pagination {

	/**
	 * Maximale anzahl an Links die bei der Seiten navigation angezeigt werden sollen
	 *
	 * @var    integer
	 */
	const MAX_SHOW_LINKS = 9;

	/**
	 * Gibt eine Seiten Navigation aus
	 *
	 * @param string  $link
	 * @param integer $count
	 * @param integer $pageNo
	 *
	 * @return string
	 */
	public static function getPagination($link, $count, $pageNo) {
		$return = '';
		if($count > 1) {
			$return .= '<ul class="pagination">';
			//Erste Seite
			$return .= self::getPreviousLink($link, $pageNo);
			//Vorherige Seite


			//Berechenung der Seitenlinks
			$return .= self::getPageLink($link, $pageNo, 1);
			$maxLinks = static::MAX_SHOW_LINKS - 4;
			$linksBeforePage = $pageNo - 2;
			if($linksBeforePage < 0)
				$linksBeforePage = 0;
			$linksAfterPage = $count - ($pageNo + 1);
			if($linksAfterPage < 0)
				$linksAfterPage = 0;
			if($pageNo > 1 && $pageNo < $count) {
				$maxLinks--;
			}

			$half = $maxLinks / 2;
			$left = $right = $pageNo;
			if($left < 1)
				$left = 1;
			if($right < 1)
				$right = 1;
			if($right > $count - 1)
				$right = $count - 1;

			if($linksBeforePage >= $half) {
				$left -= $half;
			}else {
				$left -= $linksBeforePage;
				$right += $half - $linksBeforePage;
			}

			if($linksAfterPage >= $half) {
				$right += $half;
			}else {
				$right += $linksAfterPage;
				$left -= $half - $linksAfterPage;
			}

			$right = intval(ceil($right));
			$left = intval(ceil($left));
			if($left < 1)
				$left = 1;
			if($right > $count)
				$right = $count;
			if($left > 1) {
				if($left - 1 < 2) {
					$return .= self::getPageLink($link, $pageNo, 2);
				}else {
					$return .= '<li class="unavailable" aria-disabled="true"><a>&hellip;</a></li>';
				}
			}
			//Fügt die Sichtbaren Links hinzu
			for($i = $left + 1; $i < $right; $i++) {
				$return .= self::getPageLink($link, $pageNo, $i);
			}

			if($right < $count) {
				if($count - $right < 2) {
					$return .= self::getPageLink($link, $pageNo, $count - 1);
				}else {
					$return .= '<li class="unavailable" aria-disabled="true"><a>&hellip;</a></li>';
				}

			}
			//Letzte Seite
			$return .= self::getPageLink($link, $pageNo, $count);
			//Nächste Seite
			$return .= self::getNextLink($link, $count, $pageNo);

			$return .= '</ul>';
		}
		return $return;
	}

	/**
	 * Gibt für die Seitennavigation den zurück Link
	 *
	 * @param string  $link
	 * @param integer $pageNo
	 *
	 * @return string
	 */
	protected static function getPreviousLink($link, $pageNo) {
		$result = '';
		if($pageNo > 1) {
			$result .= ' <li class="arrow"><a href="'.$link.'&amp;pageNo='.($pageNo - 1).'">&laquo;</a></li>';
		}else {
			//$result .= ' <li class="arrow unavailable"><a href="#">&laquo;</a></li>';
		}
		return $result;
	}

	/**
	 * Gibt für die Seitennavigation einen Link zurück
	 *
	 * @param string  $link
	 * @param integer $active
	 * @param integer $pageNo
	 *
	 * @return string
	 */
	protected static function getPageLink($link, $active, $pageNo) {
		$result = '';
		if($active != $pageNo) {
			$result .= ' <li><a href="'.$link.'&amp;pageNo='.$pageNo.'">'.$pageNo.'</a></li>';
		}else {
			$result .= ' <li class="current"><a href="'.$link.'&amp;pageNo='.$pageNo.'">'.$pageNo.'</a></li>';
		}
		return $result;
	}

	/**
	 * Gibt für die Seitennavigation den vor Link
	 *
	 * @param string  $link
	 * @param integer $count
	 * @param integer $pageNo
	 *
	 * @return string
	 */
	protected static function getNextLink($link, $count, $pageNo) {
		$result = '';
		if($pageNo && $pageNo < $count) {
			$result .= ' <li class="arrow"><a href="'.$link.'&amp;pageNo='.($pageNo + 1).'">&raquo;</a></li>';
		}else {
			//$result .= ' <li class="arrow unavailable"><a href="#">&raquo;</a></li>';
		}
		return $result;
	}
}