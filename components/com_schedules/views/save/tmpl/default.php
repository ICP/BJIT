<?php
// no direct access
defined('_JEXEC') or die;
$db = JFactory::getDBO();

include_once JPATH_COMPONENT_SITE . '/assets/jdf.php';
// if (strstr($_SERVER['REMOTE_ADDR'], '217.218')) { print_r($_POST); }
header('content-type: text/html; charset=utf-8');

$db->setQuery('SELECT i.id, i.title FROM #__k2_items AS i WHERE i.catid IN(3, 4, 6, 7)');
$k2items = $db->loadObjectList();
$itemsArray = array();
foreach ($k2items as $k2item) {
	$itemsArray[$k2item->title] = $k2item->id;
}

class checkItems {
	public static function validate($program, $items) {
		if (!isset($items[trim($program)])) {
		// echo trim($program);
			self::addPrograms($program);
		}
	}
	public static function addPrograms($program) {
		$db = JFactory::getDBO();
		$itemParams = '{"catItemTitle":"","catItemTitleLinked":"","catItemFeaturedNotice":"","catItemAuthor":"","catItemDateCreated":"","catItemRating":"","catItemImage":"","catItemIntroText":"","catItemExtraFields":"","catItemHits":"","catItemCategory":"","catItemTags":"","catItemAttachments":"","catItemAttachmentsCounter":"","catItemVideo":"","catItemVideoWidth":"","catItemVideoHeight":"","catItemAudioWidth":"","catItemAudioHeight":"","catItemVideoAutoPlay":"","catItemImageGallery":"","catItemDateModified":"","catItemReadMore":"","catItemCommentsAnchor":"","catItemK2Plugins":"","itemDateCreated":"","itemTitle":"","itemFeaturedNotice":"","itemAuthor":"","itemFontResizer":"","itemPrintButton":"","itemEmailButton":"","itemSocialButton":"","itemVideoAnchor":"","itemImageGalleryAnchor":"","itemCommentsAnchor":"","itemRating":"","itemImage":"","itemImgSize":"","itemImageMainCaption":"","itemImageMainCredits":"","itemIntroText":"","itemFullText":"","itemExtraFields":"","itemDateModified":"","itemHits":"","itemCategory":"","itemTags":"","itemAttachments":"","itemAttachmentsCounter":"","itemVideo":"","itemVideoWidth":"","itemVideoHeight":"","itemAudioWidth":"","itemAudioHeight":"","itemVideoAutoPlay":"","itemVideoCaption":"","itemVideoCredits":"","itemImageGallery":"","itemNavigation":"","itemComments":"","itemTwitterButton":"","itemFacebookButton":"","itemGooglePlusOneButton":"","itemAuthorBlock":"","itemAuthorImage":"","itemAuthorDescription":"","itemAuthorURL":"","itemAuthorEmail":"","itemAuthorLatest":"","itemAuthorLatestLimit":"","itemRelated":"","itemRelatedLimit":"","itemRelatedTitle":"","itemRelatedCategory":"","itemRelatedImageSize":"","itemRelatedIntrotext":"","itemRelatedFulltext":"","itemRelatedAuthor":"","itemRelatedMedia":"","itemRelatedImageGallery":"","itemK2Plugins":""}';
		$now = date('Y-m-d H:i:s', time());
		$nullDate = '0000-00-00 00:00:00';
		$insertQuery = 'INSERT INTO #__k2_items (`title`, `alias`, `catid`, `published`, `introtext`, `fulltext`, `extra_fields`, `extra_fields_search`, `created`, `created_by`, `created_by_alias`, `checked_out`, `checked_out_time`, `modified`, `modified_by`, `publish_up`, `publish_down`, `trash`, `access`, `ordering`, `image_caption`, `image_credits`, `video_caption`, `video_credits`, `hits`, `params`, `metadesc`, `metadata`, `metakey`, `plugins`, `language`) VALUES ("' . $program . '", "", 3, 0, "", "", "[]", "", "' . $now . '", "988", "", 0, "' . $nullDate . '", "' . $nullDate . '", 0, "' . $nullDate . '", "' . $nullDate . '", 0, 1, (SELECT (i.ordering + 1) FROM (SELECT * FROM #__k2_items) AS i WHERE catid = 3 ORDER BY ordering DESC LIMIT 0, 1), "", "", "", "", 0, "' . addslashes($itemParams) . '", "", "robots=\nauthor=", "", "", "*")';
		$db->setQuery($insertQuery);
		$insertResult = $db->query();
		return $insertResult;
	}
}

$saveType = JRequest::getVar('save-type'); // Get save type [edit, save]

if ($saveType != 'duplicate') {
	$form = JRequest::getVar('jform'); // Get global form data
	$id = $form['id'];
	$state = $form['state'];
	$start = JRequest::getVar('start-time');
	$end = JRequest::getVar('end-time');
	$modified_by = JRequest::getVar('user-id');
	$modified_date = date('Y-m-d H:i:s', time());
	$date = $form['date'];
		list($y, $m, $d) = explode('-', $date);
		$y = tr_num($y, 'en');
		$m = tr_num($m, 'en');
		$d = tr_num($d, 'en');
		if ($y < 2012) {
			if (intval($y) != 0) {
				$date = jalali_to_gregorian($y, $m, $d, '-');
			}
		}
	$occassion = addslashes($form['occassion']);

	$p = JRequest::getVar('programs'); // Get programs data
	$itemsCount = count($p['time']);
	$programs = new StdClass();
	for ($i = 0; $i < $itemsCount; $i++) {
		if ($p['time'][$i] || $p['program'][$i]) {
			if ($p['program'][$i]) {
				// checkItems::validate($p['program'][$i], $itemsArray);
			}
			$programs->$i->id = $i;
			$programs->$i->uid = $p['uid'][$i];
			$programs->$i->time  = $p['time'][$i];
			$programs->$i->duration = $p['duration'][$i];
			$programs->$i->name  = $p['program'][$i];
			$programs->$i->kind  = $p['kind'][$i];
			$programs->$i->part  = $p['part'][$i];
			$programs->$i->parts = ($p['parts'][$i]) ? $p['parts'][$i] : 0;
			$programs->$i->note = $p['note'][$i];
		}
	}
	$programsEncoded = addslashes(json_encode($programs));
}
function createBackup($state, $date, $occassion, $programsEncoded, $start, $end, $modified_date, $modified_by) {
	$vDb = JFactory::getDbo();
	$vQuery = $vDb->getQuery(true);
	$vQuery  = 'INSERT INTO #__schedules_versions (state, date, occassion, programs, start, end, modified, modified_by) ';
	$vQuery .= 'VALUES ("' . $state . '", "' . $date . '", "' . $occassion . '", "' . $programsEncoded . '", "' . $start . '", "' . $end . '", "' . $modified_date . '", "' . $modified_by . '")';
	// echo $vQuery; die;
	$vDb->setQuery($vQuery);
	return $vResult = $vDb->query();
}
switch ($saveType) {
	case 'edit':
		createBackup($state, $date, $occassion, $programsEncoded, $start, $end, $modified_date, $modified_by);
		$query = 'UPDATE #__schedules set checked_out = "0", checked_out_time = "0000-00-00 00:00:00", state = "' . $state . '", date = "' . $date . '", occassion = "' . $occassion . '", programs = "' . $programsEncoded . '", start = "' . $start . '", end = "' . $end . '", modified = "' . $modified_date . '", modified_by = "' . $modified_by . '" WHERE id = "' . $id . '"';
		break;
	case 'save':
		createBackup($state, $date, $occassion, $programsEncoded, $start, $end, $modified_date, $modified_by);
		$query = 'INSERT INTO #__schedules (state, date, occassion, programs, start, end) VALUES ("' . $state . '", "' . $date . '", "' . $occassion . '", "' . $programsEncoded . '", "' . $start . '", "' . $end . '")';
		break;
	case 'duplicate':
		$formerDate = JRequest::getVar('former-date');
		$newDate = JRequest::getVar('new-date');
		list($y, $m, $d) = explode('-', $newDate );
		$y = tr_num($y, 'en');
		$m = tr_num($m, 'en');
		$d = tr_num($d, 'en');
		if ($y < 2012) {
			if (intval($y) != 0) {
				$newDate = jalali_to_gregorian($y, $m, $d, '-');
			}
		}
		$selectQuery = 'SELECT s.* FROM #__schedules AS s WHERE date = "' . $formerDate . '" AND state > 0';
		$db->setQuery($selectQuery);
		$schedule = $db->loadObject();
		$programsDecoded = json_decode($schedule->programs);
		foreach ($programsDecoded as $prog) {
			if ($prog->part != 0)
				$prog->part = $prog->part + 1;
		}
		$programs = json_encode($programsDecoded);
		
		$query = 'INSERT INTO #__schedules (state, created_by, checked_out, occassion, programs, date, start, end) VALUES 
				("' . $schedule->state . '", "' . $schedule->created_by . '", "0", ' . $db->quote($db->getEscaped($schedule->occassion), false) . ', ' . $db->quote($db->getEscaped($programs), false) . ', "' . $newDate . '", "' . $schedule->start . '", "' . $schedule->end . '")';
		break;
}

$db->setQuery($query);
$result = $db->query();
// var_dump($result);


if ($result) {
	header('Location: ' . JRoute::_('index.php?option=com_schedules'));
} else {
	if (strstr($_SERVER['REMOTE_ADDR'], '217.218.')) {
		echo '<strong>' . $saveType . '</strong><br /><br /><br /><br />';
		//echo $query;
		die;
	}
}
JFactory::getApplication()->close();