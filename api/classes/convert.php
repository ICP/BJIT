<?php

jimport('joomla.filesystem.file');

class Convert {

	public $params = '{"catItemTitle":"","catItemTitleLinked":"","catItemFeaturedNotice":"","catItemAuthor":"","catItemDateCreated":"","catItemRating":"","catItemImage":"","catItemIntroText":"","catItemExtraFields":"","catItemHits":"","catItemCategory":"","catItemTags":"","catItemAttachments":"","catItemAttachmentsCounter":"","catItemVideo":"","catItemVideoWidth":"","catItemVideoHeight":"","catItemAudioWidth":"","catItemAudioHeight":"","catItemVideoAutoPlay":"","catItemImageGallery":"","catItemImageGalleryWidth":"","catItemImageGalleryHeight":"","catItemDateModified":"","catItemReadMore":"","catItemCommentsAnchor":"","catItemK2Plugins":"","itemDateCreated":"","itemTitle":"","itemFeaturedNotice":"","itemAuthor":"","itemFontResizer":"","itemPrintButton":"","itemEmailButton":"","itemSocialButton":"","itemVideoAnchor":"","itemImageGalleryAnchor":"","itemCommentsAnchor":"","itemRating":"","itemImage":"","itemImgSize":"","itemImageMainCaption":"","itemImageMainCredits":"","itemIntroText":"","itemFullText":"","itemExtraFields":"","itemDateModified":"","itemHits":"","itemCategory":"","itemTags":"","itemAttachments":"","itemAttachmentsCounter":"","itemVideo":"","itemVideoWidth":"","itemVideoHeight":"","itemAudioWidth":"","itemAudioHeight":"","itemVideoAutoPlay":"","itemVideoCaption":"","itemVideoCredits":"","itemImageGallery":"","itemImageGalleryWidth":"","itemImageGalleryHeight":"","itemNavigation":"","itemComments":"","itemTwitterButton":"","itemFacebookButton":"","itemGooglePlusOneButton":"","itemAuthorBlock":"","itemAuthorImage":"","itemAuthorDescription":"","itemAuthorURL":"","itemAuthorEmail":"","itemAuthorLatest":"","itemAuthorLatestLimit":"","itemRelated":"","itemRelatedLimit":"","itemRelatedTitle":"","itemRelatedCategory":"","itemRelatedImageSize":"","itemRelatedIntrotext":"","itemRelatedFulltext":"","itemRelatedAuthor":"","itemRelatedMedia":"","itemRelatedImageGallery":"","itemK2Plugins":""}';
	public $categoryParams = '{"inheritFrom":"0","catMetaDesc":"","catMetaKey":"","catMetaRobots":"","catMetaAuthor":"","theme":"programs","num_leading_items":"0","num_leading_columns":"1","leadingImgSize":"Large","num_primary_items":"0","num_primary_columns":"2","primaryImgSize":"Medium","num_secondary_items":"200","num_secondary_columns":"1","secondaryImgSize":"Small","num_links":"0","num_links_columns":"1","linksImgSize":"XSmall","catCatalogMode":"1","catFeaturedItems":"1","catOrdering":"","catPagination":"2","catPaginationResults":"1","catTitle":"1","catTitleItemCounter":"1","catDescription":"1","catImage":"1","catFeedLink":"1","catFeedIcon":"0","subCategories":"1","subCatColumns":"1","subCatOrdering":"order","subCatTitle":"1","subCatTitleItemCounter":"1","subCatDescription":"1","subCatImage":"1","itemImageXS":"","itemImageS":"","itemImageM":"","itemImageL":"","itemImageXL":"","catItemTitle":"1","catItemTitleLinked":"1","catItemFeaturedNotice":"0","catItemAuthor":"0","catItemDateCreated":"1","catItemRating":"0","catItemImage":"1","catItemIntroText":"0","catItemIntroTextWordLimit":"","catItemExtraFields":"0","catItemHits":"0","catItemCategory":"0","catItemTags":"0","catItemAttachments":"0","catItemAttachmentsCounter":"0","catItemVideo":"0","catItemVideoWidth":"","catItemVideoHeight":"","catItemAudioWidth":"","catItemAudioHeight":"","catItemVideoAutoPlay":"0","catItemImageGallery":"0","catItemImageGalleryWidth":"","catItemImageGalleryHeight":"","catItemDateModified":"0","catItemReadMore":"0","catItemCommentsAnchor":"1","catItemK2Plugins":"1","itemDateCreated":"1","itemTitle":"1","itemFeaturedNotice":"1","itemAuthor":"0","itemFontResizer":"1","itemPrintButton":"1","itemEmailButton":"1","itemSocialButton":"1","itemVideoAnchor":"1","itemImageGalleryAnchor":"1","itemCommentsAnchor":"1","itemRating":"1","itemImage":"1","itemImgSize":"Large","itemImageMainCaption":"1","itemImageMainCredits":"1","itemIntroText":"1","itemFullText":"1","itemExtraFields":"1","itemDateModified":"1","itemHits":"1","itemCategory":"1","itemTags":"1","itemAttachments":"1","itemAttachmentsCounter":"1","itemVideo":"1","itemVideoWidth":"","itemVideoHeight":"","itemAudioWidth":"","itemAudioHeight":"","itemVideoAutoPlay":"0","itemVideoCaption":"1","itemVideoCredits":"1","itemImageGallery":"1","itemImageGalleryWidth":"","itemImageGalleryHeight":"","itemNavigation":"1","itemComments":"1","itemTwitterButton":"1","itemFacebookButton":"1","itemGooglePlusOneButton":"1","itemAuthorBlock":"1","itemAuthorImage":"1","itemAuthorDescription":"1","itemAuthorURL":"1","itemAuthorEmail":"0","itemAuthorLatest":"1","itemAuthorLatestLimit":"5","itemRelated":"1","itemRelatedLimit":"5","itemRelatedTitle":"1","itemRelatedCategory":"0","itemRelatedImageSize":"0","itemRelatedIntrotext":"0","itemRelatedFulltext":"0","itemRelatedAuthor":"0","itemRelatedMedia":"0","itemRelatedImageGallery":"0","itemK2Plugins":"1"}';

	// Constructor
	function Convert($app, $type = null) {
		if (empty($type))
			$app->render(200, array('msg' => 'No convert type mentioned'));
		switch ($type) {
			default:
				$app->render(200, array('msg' => 'Convert type not supported'));
				break;
			case 'products':
				$this->products($app, $type);
				break;
			case 'news':
				$this->news($app, $type);
				break;
			case 'latest':
				$this->latest($app, $type);
				break;
			case 'programs':
				$this->programs($app, $type);
				break;
			case 'videos':
				$this->orphans($app, $type);
				break;
			case 'schedule':
				$this->schedule($app, $type);
				break;
		}
	}

	function products($app, $type) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('products'))
				->where($app->_db->quoteName('published') . ' != ' . $app->_db->quote('0'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldItems = $app->_db->loadObjectList();
		$items = [];

		foreach ($oldItems as $item) {
			$o = new stdClass();
			$o->title = $item->title;
			$o->alias = self::createItemAlias($item->title);
			$o->catid = 6; // بانک جامع اطلاعات تولید شبکه
			$o->published = $item->published;
			$o->introtext = $item->summary;
			$o->fulltext = $item->body;
			$o->extra_fields = "[]";
			$o->created = $item->submitted_at;
			$o->created_by = 576;
			$o->created_by_alias = "";
			$o->checked_out = 0;
			$o->checked_out_time = "0000-00-00 00:00:00";
			$o->modified = "0000-00-00 00:00:00";
			$o->modified_by = 576;
			$o->publish_up = $item->startPublishing;
			$o->publish_down = "0000-00-00 00:00:00";
			$o->trash = 0;
			$o->access = 1;
			$o->ordering = $item->priority;
			$o->featured = 0;
			$o->featured_ordering = 0;
			$o->image_caption = "";
			$o->image_credits = "";
			$o->video_caption = "";
			$o->video_credits = "";
			$o->hits = 0;
			$o->params = $this->params;
			$o->metadesc = "";
			$o->metadata = "";
			$o->metakey = "";
			$o->plugins = "";
			$o->language = "*";

			$imagePath = self::handleImagePath($item->id, $item->image, $type);
			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__k2_items', $o);
			$id = $results->id = $app->_db->insertid();
			$results->img = self::convertImage($imagePath, $id);

			$items[] = $results;
		}

		$app->render(200, array('retults' => $items,));
	}

	function news($app, $type) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('news'))
				->where($app->_db->quoteName('id') . ' > ' . $app->_db->quote('726'));
//				->where($app->_db->quoteName('published') . ' != ' . $app->_db->quote('0'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldItems = $app->_db->loadObjectList();
		$items = [];

		foreach ($oldItems as $item) {
			$o = new stdClass();
			if ($item->headline) {
				$extrafields = new stdClass();
				$extrafields->id = 7;
				$extrafields->value = $item->headline;
			}
			$o->title = $item->title;
			$o->alias = self::createItemAlias($item->title);
			$o->catid = 3; // بانک جامع اطلاعات تولید شبکه
			$o->published = $item->published;
			$o->introtext = $item->summary;
			$o->fulltext = $item->body;
			$o->extra_fields = ($item->headline) ? "[" . json_encode($extrafields) . "]" : "[]";
			$o->created = $item->submitted_at;
			$o->created_by = 576;
			$o->created_by_alias = "";
			$o->checked_out = 0;
			$o->checked_out_time = "0000-00-00 00:00:00";
			$o->modified = "0000-00-00 00:00:00";
			$o->modified_by = 576;
			$o->publish_up = "1970-01-01 00:00:00";
			$o->publish_down = "0000-00-00 00:00:00";
			$o->trash = 0;
			$o->access = 1;
			$o->ordering = 1;
			$o->featured = $item->topnews;
			$o->featured_ordering = 0;
			$o->image_caption = "";
			$o->image_credits = "";
			$o->video_caption = "";
			$o->video_credits = "";
			$o->hits = 0;
			$o->params = $this->params;
			$o->metadesc = "";
			$o->metadata = "";
			$o->metakey = "";
			$o->plugins = "";
			$o->language = "*";

			$imagePath = self::handleImagePath($item->id, $item->image, $type);
			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__k2_items', $o);
			$id = $results->id = $app->_db->insertid();
			$results->img = self::convertImage($imagePath, $id);

			$items[] = $results;
		}
		$app->render(200, array('items ' => $items,));
	}

	function programs($app, $type) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('lookup'))
				->where($app->_db->quoteName('disabled') . ' != ' . $app->_db->quote('1'), ' AND')
				->where($app->_db->quoteName('id') . ' > ' . $app->_db->quote('163'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldItems = $app->_db->loadObjectList();
		$items = [];

		$order = 1;
		foreach ($oldItems as $item) {
			$items[] = $item;
			$o = new stdClass();
			$o->name = $item->name;
			$o->alias = self::createItemAlias($item->name);
			$o->description = $item->description;
			$o->parent = 2;
			$o->extraFieldsGroup = 4;
			$o->published = 1;
			$o->access = 1;
			$o->ordering = $order;
			$o->image = $item->image;
			$o->params = $this->categoryParams;
			$o->trash = 0;
			$o->plugins = 0;
			$o->language = "*";

			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__k2_categories', $o);
			$catid = $results->id = $app->_db->insertid();
			$results->title = $item->name;

			$catImage = $results->imgOriginal = self::handleCatImagePath($item->id, $o->image);
			$catImageUploaded = self::saveCatImage($catImage, $catid);

			$updateCat = $app->_db->getQuery(true);
			$updateCat = 'UPDATE #__k2_categories SET image = ' . $app->_db->quote($catImageUploaded) . ' WHERE id = ' . $app->_db->quote($catid);
			$app->_db->setQuery($updateCat);
			$results->updateCatImg = $app->_db->execute();

			$results->children = $this->programItems($app, $catid, $item->id);
			$output[] = $results;
			$order++;
		}
		$app->render(200, array('items ' => $output,));
	}

	function programItems($app, $catid, $itemCatid) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('programs'))
				->where($app->_db->quoteName('category') . ' = ' . $app->_db->quote($itemCatid));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldPrograms = $app->_db->loadObjectList();
		$itemOrder = 1;
		$items = [];
		if (empty($oldPrograms))
			return false;
		foreach ($oldPrograms as $item) {
			$o = new stdClass();
			$o->title = $item->title;
			$o->alias = self::createItemAlias($item->title);
			$o->catid = $catid;
			$o->published = $item->published;
			$o->introtext = $item->summary;
			$o->fulltext = $item->body;
			$o->video = ($item->fileaddress) ? '{mp4}$old|' . $item->fileaddress . '{/mp4}' : null;
			$o->extra_fields = '[{"id":"8","value":"' . $item->duration . '"},{"id":"9","value":"' . $item->production_date . '"},{"id":"10","value":"' . $item->scheduled_on . '"},{"id":"11","value":"' . $item->first_run . '"}]';
			$o->extra_fields_search = '"' . $item->duration . ' ' . $item->production_date . ' ' . $item->scheduled_on . ' ' . $item->first_run;
			$o->created = $item->submitted_at;
			$o->created_by = 576;
			$o->created_by_alias = "";
			$o->checked_out = 0;
			$o->checked_out_time = "0000-00-00 00:00:00";
			$o->modified = "0000-00-00 00:00:00";
			$o->modified_by = 576;
			$o->publish_up = $item->startPublishing;
			$o->publish_down = "0000-00-00 00:00:00";
			$o->trash = 0;
			$o->access = 1;
			$o->ordering = $itemOrder;
			$o->featured = 0;
			$o->featured_ordering = 0;
			$o->image_caption = "";
			$o->image_credits = "";
			$o->video_caption = "";
			$o->video_credits = "";
			$o->hits = 0;
			$o->params = $this->params;
			$o->metadesc = "";
			$o->metadata = "";
			$o->metakey = "";
			$o->plugins = "";
			$o->language = "*";

			$imagePath = self::handleImagePath($item->id, $item->thumb, 'programs', true);
			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__k2_items', $o);
			$id = $results->id = $app->_db->insertid();
			$results->img = self::convertImage($imagePath, $id);

			$results->imgPath = $imagePath;
			$results->imgOriginal = $item->thumb;

			$items[] = $results;
			$itemOrder++;
		}
		return $items;
	}

	function orphans($app) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('programs'))
				->where($app->_db->quoteName('submitted_at') . ' > ' . $app->_db->quote('2015-10-01'), ' AND')
				->where($app->_db->quoteName('fileaddress') . ' != ' . $app->_db->quote(''), ' AND')
				->where($app->_db->quoteName('category') . ' = ' . $app->_db->quote('0'), ' AND')
				->where($app->_db->quoteName('published') . ' != ' . $app->_db->quote('0'), ' AND')
				->where($app->_db->quoteName('episode') . ' IS NULL ', ' AND')
				->where($app->_db->quoteName('title') . ' NOT LIKE ' . $app->_db->quote('%\_%'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldItems = $app->_db->loadObjectList();
		$items = [];

		$order = 127;
		foreach ($oldItems as $item) {
			$items[] = $item;
			$c = new stdClass();
			$c->name = $item->title;
			$c->alias = self::createItemAlias($item->title);
			$c->description = $item->summary;
			$c->parent = 2;
			$c->extraFieldsGroup = 4;
			$c->published = 1;
			$c->access = 1;
			$c->ordering = $order;
			$c->image = $item->thumb;
			$c->params = $this->categoryParams;
			$c->trash = 0;
			$c->plugins = 0;
			$c->language = "*";

			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__k2_categories', $c);
			$catid = $results->id = $app->_db->insertid();
			$results->title = $item->title;

			$catImage = $results->imgOriginal = self::handleImagePath($item->id, $c->image, 'programs', true);
			$catImageUploaded = self::saveCatImage($catImage, $catid);

			$updateCat = $app->_db->getQuery(true);
			$updateCat = 'UPDATE #__k2_categories SET image = ' . $app->_db->quote($catImageUploaded) . ' WHERE id = ' . $app->_db->quote($catid);
			$app->_db->setQuery($updateCat);
			$results->updateCatImg = $app->_db->execute();

			$results->child = $this->orphanItems($app, $item, $catid);
			$output[] = $results;
			$order++;
		}

		$app->render(200, array('items ' => $output,));
	}

	function orphanItems($app, $item, $catid) {
		$o = new stdClass();
		$o->title = $item->title;
		$o->alias = self::createItemAlias($item->title);
		$o->catid = $catid;
		$o->published = $item->published;
		$o->introtext = $item->summary;
		$o->fulltext = $item->body;
		$o->video = ($item->fileaddress) ? '{mp4}$old|' . $item->fileaddress . '{/mp4}' : null;
		$o->extra_fields = '[{"id":"8","value":"' . $item->duration . '"},{"id":"9","value":"' . $item->production_date . '"},{"id":"10","value":"' . $item->scheduled_on . '"},{"id":"11","value":"' . $item->first_run . '"}]';
		$o->extra_fields_search = '"' . $item->duration . ' ' . $item->production_date . ' ' . $item->scheduled_on . ' ' . $item->first_run;
		$o->created = $item->submitted_at;
		$o->created_by = 576;
		$o->created_by_alias = "";
		$o->checked_out = 0;
		$o->checked_out_time = "0000-00-00 00:00:00";
		$o->modified = "0000-00-00 00:00:00";
		$o->modified_by = 576;
		$o->publish_up = $item->startPublishing;
		$o->publish_down = "0000-00-00 00:00:00";
		$o->trash = 0;
		$o->access = 1;
		$o->ordering = 1;
		$o->featured = 0;
		$o->featured_ordering = 0;
		$o->image_caption = "";
		$o->image_credits = "";
		$o->video_caption = "";
		$o->video_credits = "";
		$o->hits = 0;
		$o->params = $this->params;
		$o->metadesc = "";
		$o->metadata = "";
		$o->metakey = "";
		$o->plugins = "";
		$o->language = "*";

		$imagePath = self::handleImagePath($item->id, $item->thumb, 'programs', true);
		$results = new stdClass();
		$results->db = $app->_db->insertObject('#__k2_items', $o);
		$id = $results->id = $app->_db->insertid();
		$results->img = self::convertImage($imagePath, $id);

		$results->imgPath = $imagePath;
		$results->imgOriginal = $item->thumb;

		return $results;
	}

	function schedule($app) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('timetable'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldItems = $app->_db->loadObjectList();
		$items = [];
		$i = 0;
		foreach ($oldItems as $item) {
			$program = $this->checkIfItemExists($app, $item->title);
			if (!$program) {
				$program = new stdClass();
				$program->id = null;
			}
			$items[$i]["program"] = $program->id;
			@$items[$i]["title"] = $program->name;

			$o = new stdClass();
			$o->state = $item->visible;
			$o->revision = 0;
			$o->title = $item->title;
			$o->program_id = $program->id;
			$o->episode = "";
			$o->start = $item->scheduledAt;
//			$o->duration = "";
			$o->kind = "program";
			$o->params = "";
			$o->created = $item->createdAt;
			$o->created_by = 576;
			$o->checked_out = 0;
			$o->checked_out_time = "0000-00-00 00:00:00";
			$o->modified = "0000-00-00 00:00:00";
			$o->modified_by = 576;

			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__schedules', $o);
			$results->id = $app->_db->insertid();

			$items[$i]["schedule"] = $o->title;
			$items[$i]["result"] = $results;
			$i++;
		}
		$app->render(200, array('program ' => $items,));
	}

	function checkIfItemExists($app, $title) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('#__k2_categories'))
				->where($app->_db->quoteName('name') . ' LIKE ' . $app->_db->quote('%' . trim($title) . '%'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$item = $app->_db->loadObject();
		if ($item)
			return $item;
		else
			return false;
	}

	// Common Movies
	function latest($app, $type) {
		$query = $app->_db->getQuery(true);
		$query->select('*')
				->from($app->_db->quoteName('common_movies'));
//				->where($app->_db->quoteName('published') . ' != ' . $app->_db->quote('0'));
		$app->_db->setQuery($query);
		$app->_db->execute();
		$oldItems = $app->_db->loadObjectList();
		$items = [];

		foreach ($oldItems as $item) {
			$o = new stdClass();
			$o->title = $item->title;
			$o->alias = self::createItemAlias($item->title);
			$o->catid = 7; // تازه‌های مستند
			$o->published = $item->published;
			$o->introtext = $item->summary;
			$o->fulltext = $item->body;
			$o->video = ($item->fileaddress) ? '{mp4}$old|' . $item->fileaddress . '{/mp4}' : null;
			$o->extra_fields = "[]";
			$o->created = $item->createdAt;
			$o->created_by = 576;
			$o->created_by_alias = "";
			$o->checked_out = 0;
			$o->checked_out_time = "0000-00-00 00:00:00";
			$o->modified = "0000-00-00 00:00:00";
			$o->modified_by = 576;
			$o->publish_up = $item->startPublishing;
			$o->publish_down = "0000-00-00 00:00:00";
			$o->trash = 0;
			$o->access = 1;
			$o->ordering = ($item->priority) ? $item->priority : 1;
			$o->featured = 0;
			$o->featured_ordering = 0;
			$o->image_caption = "";
			$o->image_credits = "";
			$o->video_caption = "";
			$o->video_credits = "";
			$o->hits = 0;
			$o->params = $this->params;
			$o->metadesc = "";
			$o->metadata = "";
			$o->metakey = "";
			$o->plugins = "";
			$o->language = "*";

			$imagePath = self::handleImagePath($item->id, $item->thumb, $type, true);
			$results = new stdClass();
			$results->db = $app->_db->insertObject('#__k2_items', $o);
			$id = $results->id = $app->_db->insertid();
			$results->img = self::convertImage($imagePath, $id);

			$items[] = $results;
		}

		$app->render(200, array('retults' => $items,));
	}

	/*
	 * Helper static methods
	 */

	static function handleImagePath($id, $img, $type, $isThumb = false) {
		$type = ($type == "latest") ? "commonmovies" : $type;
		$path = 'http://ftp4.presstv.ir/mostanad/' . $type;
		$idLen = strlen($id);
		for ($i = 0; $i < $idLen; $i++)
			$path .= '/' . substr($id, $i, 1);
		$path .= ($isThumb) ? '/thumb/' . $img : '/' . $img;
		return $path;
	}

	static function handleCatImagePath($id, $img) {
		$path = 'http://ftp4.presstv.ir/mostanad/cat';
		$idLen = strlen($id);
		for ($i = 0; $i < $idLen; $i++)
			$path .= '/' . substr($id, $i, 1);
		$path .= '/thumb/' . $img;
		return $path;
	}

	static function convertImage($img, $id) {

		if (!class_exists('upload'))
			require_once (dirname(__FILE__) . '/../libraries/class.upload.php');
		$destination = self::saveImage($img, $id);
		$handle = new Upload($destination);
		$handle->forbidden = array('image/tiff');
		if ($handle->file_is_image && $handle->uploaded) {

			//Original image
			$savepath = JPATH_BASE . '/media/k2/items/src';
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 100;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = md5("Image" . $id);
			$handle->Process($savepath);

			$filename = $handle->file_dst_name_body;
			$savepath = JPATH_BASE . '/media/k2/items/cache';

			//XLarge image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 60;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename . '_XL';
			$handle->image_x = 1920;
			$handle->Process($savepath);

			//Large image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 60;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename . '_L';
			$handle->image_x = 1280;
			$handle->Process($savepath);

			//Medium image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 60;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename . '_M';
			$handle->image_x = 600;
			$handle->Process($savepath);

			//Small image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 60;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename . '_S';
			$handle->image_x = 400;
			$handle->Process($savepath);

			//XSmall image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 60;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename . '_XS';
			$handle->image_x = 200;
			$handle->Process($savepath);

			//Generic image
			$handle->image_resize = true;
			$handle->image_ratio_y = true;
			$handle->image_convert = 'jpg';
			$handle->jpeg_quality = 60;
			$handle->file_auto_rename = false;
			$handle->file_overwrite = true;
			$handle->file_new_name_body = $filename . '_Generic';
			$imageWidth = 600;
			$handle->image_x = $imageWidth;
			$handle->Process($savepath);

			$handle->Clean();
			return true;
		} else {
//			echo "\n not ok $id";
		}
		return false;
	}

	static function saveImage($img, $id) {
		$ch = curl_init();
		$source = $img;
		curl_setopt($ch, CURLOPT_URL, $source);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);

		$destination = JPATH_BASE . '/media/k2/items/temp/' . $id . '.jpg';
		$file = fopen($destination, "w+");
		fputs($file, $data);
		fclose($file);

		return $destination;
	}

	static function saveCatImage($img, $id) {
		$ch = curl_init();
		$source = $img;
		curl_setopt($ch, CURLOPT_URL, $source);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		curl_close($ch);

		$destination = JPATH_BASE . '/media/k2/categories/' . $id . '.jpg';
		$file = fopen($destination, "w+");
		fputs($file, $data);
		fclose($file);

		return $id . '.jpg';
	}

	static function createItemAlias($string) {
		return JFilterOutput::stringURLUnicodeSlug($string);
	}

}
