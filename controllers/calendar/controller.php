<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
/**
 * Calendar controller.
 *
 * @package truenorthng
 * @subpackage Controller
 */

final class Controller_Calendar extends Controller {
	public function config($method = NULL) {
		$this->route = array(
			'name' => _('Calendar'),
			'view' => 'calendar',
			'main_order' => 20
		);
		
		$this->permission = array(
			'viewCalendar'
		);

		$this->pageTitle = $this->route['name'];
		$this->showPageNav = TRUE;
		$this->ignoreDatesFor = array(
			'Competency',
			'Objective'
		);
		return parent::config($method);
	}
	
	public function config_ical($params = NULL) {
		$this->route['view'] ='ical';
		$this->showPageNav = FALSE;

		unset($this->route['main_order']);
	}

	public function config_index($params = NULL) {

		$this->permission = array(
			'authenticated'
		);
		$this->route['main_order'] = 20;

	}	
	
	/**
	 * The default method.
	 */
	public function call_index($url) {
		$objects = flattenFilterItems(getFiltered($this->G, 0, 0, NULL, NULL, NULL, NULL, NULL, TRUE), FALSE, FALSE);
		$currentUser = session('user_filter');
		if (empty($currentUser)) {
			$currentUser = $this->G->user->id;
		}
		$iCalParams = session('property').','.session('division').','.session('department').','.$currentUser.','.$this->G->user->id;
		$tokens = array(
			'encrypted' => base64_encode(str_rot13($iCalParams)),
			'checksum' => sha1($iCalParams . $this->G->user->key . SYSTEM_SALT)
		);
		$iCal = http_build_query(
			array(
				'calid' => urlencode($tokens['encrypted']),
				'checksum' => $tokens['checksum']
			),
			'',
			'&'
		);
		$currentYear = session('year');
		$currentMonth = session('month');
		if ($currentYear == '') {
			$currentYear = date('Y', time());
		}
		if ($currentMonth == '') {
			$currentMonth = 0;
		}
		if ($currentMonth == 0) {
			$currentMonth = date('n', time());
		}

		$objectList = objectList(TRUE);

		$modals = array();
		$iCalModal = null;
		$calendar = Calendar::factory($currentMonth, $currentYear);
		$calendar->standard('today')
			->standard('prev-next')
			->standard('holidays');
		foreach ($objects as $id => $object) {
			
			//echo "<pre>";
			//print_r($objects);
			//exit;
			
			if($object["user_id"] != $currentUser) continue;
			
			$type = $this->G->ids->type($id);
			foreach ($objectList[$type]['dates'] as $dateType) {
				//echo "<pre>".ucfirst($type).' - '.ucFirst($dateType)."</pre>";
				//echo "<pre>$id, $dateType - ".$object[$dateType]."</pre>";
				if ($object[$dateType] != '') {
					$label = 'label-info';
					switch (strtolower($dateType)) {
						case 'complete':
							$label = 'label-success';
							break;
						case 'due':
							if ($object[$dateType] < (time() + (60 * 60 * 72))) {
								$label = 'label-warning';
							}
							if ($object[$dateType] < time()) {
								$label = 'label-danger';
							}
							break;
						default:
							$label = 'label-info';
							break;
					}
					$event = $calendar->event()
						->condition('timestamp', $object[$dateType])
						->title(strtolower($type).' - '.$id)
						->output('<li class="'.$label.'"><a href="#cal'.$object['id'].'" data-toggle="modal" class="label">'.ucfirst($type).' - '.$object['description'].' - '.ucFirst($dateType).'</a></li>')
						->add_class('cal-'.strtolower($type));
					$calendar->attach($event);
					$modals[$object['id']] = $object;
					$modals[$object['id']]['type'] = $type;
				}
			}
		}
		$iCalLink = HOST.$this->G->url->getUrl().'ical?'.$iCal;
		
		$iCalModal = '<p>Use the iCal Feed below to easily add this calendar to your Outlook.</p>';
		$iCalModal .= '<p><input type="text" value="'.$iCalLink.'" style="width:80%;"/></p>';
		$iCalModal .= '<ol>';
		$iCalModal .= "<li>In Outlook 2007, select Tools / Account Settings.</li>";
		$iCalModal .= "<li>Click the Internet Calendars tab.</li>";
		$iCalModal .= "<li>Click New.</li>";
		$iCalModal .= "<li>Enter the URL you copied from above.</li>";
		$iCalModal .= "<li>Click the Add button.</li>";
		$iCalModal .= "<li>Make changes to the Folder Name, as desired.</li>";
		$iCalModal .= "<li>Click the OK button.</li>";
		$iCalModal .= "<li>Click the Close button.</li>";
		$iCalModal .= '</ol>';
		$iCalModal .= '<p>In the Calendar left pane, the new calendar will appear in your Other Calendars section.</p>';
		
		$modals['iCal']['id'] = 'iCal';
		$modals['iCal']['description'] = $iCalModal;
		$modals['iCal']['type'] = "iCal";
		tpl_set('calendar', $calendar);
		tpl_set('iCal', $iCal);
		tpl_set('iCalLink', $iCalLink);
		tpl_set('modals', $modals);
		parent::display();
	}
	

	public function call_ical($url) {
		$iCalParams = str_rot13(base64_decode(urldecode($this->G->url->getQuerystringBit('calid'))));
		$paramIds = explode(',', $iCalParams);
		
		//print_r($paramIds);
		
		if(count($paramIds) != 5){
			die(_('Invalid iCal link.'));
		}

		$checksum = $this->G->url->getQuerystringBit('checksum');
		$userId = $paramIds[4];
		$user = get_model('user')->loadUser($userId);
		$newChecksum = sha1($iCalParams . $user['key'] . SYSTEM_SALT);
		if ($checksum != $newChecksum) {
			die(_('Invalid iCal link checksum.'));
		}
		
		$objects = flattenFilterItems(getFiltered($this->G, 1, END_OF_TIME, $paramIds[0], $paramIds[1], $paramIds[2], $paramIds[3], $paramIds[4], TRUE), FALSE, FALSE);
		
		//print_r($objects);exit;
		tpl_set('iCalObjs', $objects);
		tpl_set('assignedTo', $userId);
		parent::display(FALSE);
	}
}
