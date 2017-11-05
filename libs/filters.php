<?php defined('SYSTEM_PATH') OR die('No direct access to this file is allowed.');
/**
 * Filter-related functions.
 *
 * @package    truenorthng
 * @subpackage Library
 */

function objectList($cal = FALSE) {
	$return = array();
	if ($cal) {
		$dates = array(
			'Strategy' => array(
				'model' => 'strategy',
				'dates' => array(
					'start',
					'due',
					'complete'
				)
			),
			'Tactic' => array(
				'model' => 'tactic',
				'dates' => array(
					'due',
					'complete'
				)
			)
		);
	} else {
		$dates = array(
			'Objective' => array(
				'model' => 'objective',
				'dates' => array(
					'start',
					'due'
				)
			),
			'Strategy' => array(
				'model' => 'strategy',
				'dates' => array(
					'due',
					'complete'
				)
			),
			'Tactic' => array(
				'model' => 'tactic',
				'dates' => array(
					'due',
					'complete'
				)
			)
		);
	}
	$return = $dates;
	return $return;
}

function getFiltered(G $G, $start = 0, $end = 0, $propertyId = NULL, $divisionId = NULL, $departmentId = NULL, $filterId = NULL, $userId = NULL, $forDisplay = FALSE) {
	$return = array();
	$rawList = array();
	$year = session('year');
	$month = session('month');

	if (empty($propertyId)) {
		$propertyId = session('property');
	}
	if (empty($divisionId)) {
		$divisionId = session('division');
	}
	if (empty($departmentId)) {
		$departmentId = session('department');
	}
	if (empty($filterId)) {
		$filterId = session('user_filter');
	}
	if (empty($userId)) {
		$userId = session('user');
	}
	
	if (session('user_filter')){
		$userId = session('user_filter');
	} /* else {
		$userId = session('user');
	} */
	
	if (empty($month)) {
		$month = 0;
	}
	if (empty($year)) {
		$year = date("Y");
		$start = 0;
		$end = $year . '-12-31 23:59:59';
	}
		if ($start == 0) {
			if ($month == 0) {
				$start = $year . '-01-01 00:00:00';
			} else {
				$start = $year . '-' . $month . '-01 00:00:00';
			}
			$start = strtotime($start);
		}
		if ($end == 0) {
			if ($month == 0) {
				$end = $year . '-12-31 23:59:59';
			} else {
				$end = $year . '-' . $month . '-' . date('t', strtotime($year . '-' . $month . '-01 00:00:00')) . ' 23:59:59';
			}
			$end = strtotime($end);
		}
/*
pr('1388559600 - ' . date('Y-m-d H:i:s', '1388559600'));
pr('2147483648 - ' . date('Y-m-d H:i:s', '2147483648'));

pr('1393657200 - ' . date('Y-m-d H:i:s', '1393657200'));
pr('2147483648 - ' . date('Y-m-d H:i:s', '2147483648'));

pr('1388559600 - ' . date('Y-m-d H:i:s', '1388559600'));
pr('1420095599 - ' . date('Y-m-d H:i:s', '1420095599'));
*/

	//pr($start . ' - ' . date('Y-m-d H:i:s e', $start));
	//pr($end . ' - ' . date('Y-m-d H:i:s e', $end));
	//exit;

	$competencyModel = get_model('competency');
	$objectiveModel = get_model('objective');
	$strategyModel = get_model('strategy');
	$attachmentModel = get_model('attachment');
	if (user_has('viewCompetency', $userId)) {

		$competencyModel->cid = $userId;
		$rawList = $competencyModel->getCompetencies($propertyId);
		
		//print_r($rawList);exit;
		
		foreach ($rawList as $cid => $competency) {
			// Get Objectives belonging to each Competency.
			if (!array_key_exists('_objectives', $rawList[$cid])) {
				$rawList[$cid]['_objectives'] = array();
			}
			if (!array_key_exists('_strategies', $rawList[$cid])) {
				$rawList[$cid]['_strategies'] = array();
			}
			if (user_has('viewObjective', $userId)) {
				$objectives = $competencyModel->getFilteredObjectives($cid, $propertyId, $start, $end, $divisionId, $departmentId, $filterId, $userId);
				
				//print_r($objectives);
				
				foreach ($objectives as $oid => $objective){
					$objective['_attachments'] = array();
					$objective['_attachments'] = $attachmentModel->getAttachments($oid);
					$objective['_strategies'] = array();
					//if ($objective['cid'] == $userId || $objective['user_id'] == $filterId || $objective['user_id'] == NULL){
						$rawList[$cid]['_objectives'][$oid] = $objective;
					//}
				}
			}
			if (user_has('viewStrategy', $userId)) {
				$strategyList = $competencyModel->getFilteredStrategies($cid, $propertyId, $start, $end, $divisionId, $departmentId, $filterId, $userId, $forDisplay);
				
				//print_r($strategyList);
				foreach ($strategyList as $sid => $strategy) {
					$strategy['_tactics'] = array();
				
					//if ($strategy['private'] == 1 && $strategy['user_id'] != $userId) continue;
					
					$excludeStrategy = true;
					
					//if ($strategy['user_id'] == $userId || $strategy['cid'] == $userId){
						
						$strategy['_attachments'] = array();
						$strategy['_attachments'] = $attachmentModel->getAttachments($sid);
						$tacticsList = $strategyModel->getFilteredTactics($sid, $start, $end);
						foreach ($tacticsList as $tid => $tactic) {
							
							$tactic['_attachments'] = array();
							$tactic['_attachments'] = $attachmentModel->getAttachments($tid);
							$strategy['_tactics'][$tid] = $tactic;
							
							if($tactic['user_id'] == $userId || $tactic['cid'] == $userId) {
								$excludeStrategy = false;
							} 
						}
						
						if($G->controller == 'strategiestactics') {

							//echo 'test';
							//echo $strategy['user_id'] . '<br/>';
							if ($strategy['user_id'] != "$userId" && $strategy['cid'] != "$userId" && $excludeStrategy == true){
								continue;
							}
						
						}						
						
						
						$rawList[$cid]['_strategies'][$sid] = $strategy;
						if (user_has('viewObjective', $userId)) {
							if (array_key_exists('_objective', $strategy) && isset($rawList[$cid]['_objectives'][$strategy['_objective']])) {
								$rawList[$cid]['_objectives'][$strategy['_objective']]['_strategies'][$sid] = $strategy;
							}
						}
					//}
				}
			}
			//$objectives = $objectiveModel->getFilteredStrategies($oid, $propertyId, $start, $end, $divisionId, $departmentId, $filterId, $userId, $forDisplay);
		}
		$return = $rawList;
		//echo $G->url;
		//pr($userId);
		//pr($return);
		return $return;
	}
}

function flattenFilterItems($items, $includeCompetency = FALSE, $includeObjective = TRUE, $includeStrategy = TRUE, $includeTactic = TRUE) {
	$return = array();
	 if(empty($items)){
            $items = array();
        }
	foreach ($items as $cid => $competency) {
		if ($includeCompetency) {
			$return[$cid] = $competency;
			unset($return[$cid]['_objectives'], $return[$cid]['_strategies']);
		}
		foreach ($competency['_objectives'] as $oid => $objective) {
			if ($includeObjective) {
				$return[$oid] = $objective;
				unset($return[$oid]['_strategies']);
			}
			foreach ($objective['_strategies'] as $sid => $strategy) {
				if ($includeStrategy) {
					$return[$sid] = $strategy;
					unset($return[$sid]['_tactics'], $return[$sid]['_attachments']);
					foreach ($strategy['_tactics'] as $tid => $tactic) {
						if ($includeTactic) {
							$return[$tid] = $tactic;
							unset($return[$tid]['_attachments']);
						}
					}
				}
			}
		}
		foreach ($competency['_strategies'] as $sid => $strategy) {
			if ($includeStrategy) {
				$return[$sid] = $strategy;
				unset($return[$sid]['_tactics'], $return[$sid]['_attachments']);
				foreach ($strategy['_tactics'] as $tid => $tactic) {
					if ($includeTactic) {
						$return[$tid] = $tactic;
						unset($return[$tid]['_attachments']);
					}
				}
			}
		}
	}
	return $return;
}

function getDateArray(G $G, $includeNow = FALSE, $exclude = array()) {
	return array();
	
	$objects = flattenFilterItems(getFiltered($G, 1, END_OF_TIME));
	//pr($objects);die();
	$objectList = objectList();
	$dates = array();
	foreach ($objects as $id => $object) {
		$type = $G->ids->type($id);
		if (isset($type) && !in_array($type, $G->controllerList['allowed'][$G->controller]->ignoreDatesFor)) {
			foreach ($objectList[$type]['dates'] as $dateType) {
				if (isset($object[$dateType]) && $object[$dateType] != '') {
					$year = date('Y', $object[$dateType]);
					if (!isset($dates[$year])) {
						$dates[$year] = array();
					}
					$month = date('n', $object[$dateType]);
					$name = date('F', $object[$dateType]);
					if (!in_array($month, $dates[$year])) {
						$dates[$year][$month] = $name;
					}
				}
			}
		}
	}
/*
	if ($includeNow) {
		$defaultYear = date('Y', time());
		$defaultMonth = date('n', time());
		$defaultDate = array(
			$defaultYear => array(
				$defaultMonth => date('F', strtotime("$defaultYear-$defaultMonth-01"))
			)
		);
		if (!isset($dates[$defaultYear])) {
			$dates[$defaultYear] = array();
		}
		$dates[$defaultYear] = $dates[$defaultYear] + $defaultDate[$defaultYear];
	}
*/
	ksort($dates);

	foreach ($dates as $year => &$months) {
		uksort($months, function ($a, $b) {
			return $a > $b;
		});
	}

	//pr($dates, 'GETDATEARRAY ');

	return $dates;
}
