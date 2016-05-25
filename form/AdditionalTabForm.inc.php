<?php

/**
  * @file plugins/generic/catalogEntryTab/form/AdditionalTabForm.inc.php
  *
  * Copyright (c) 2016 Language Science Press
  * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
  *
  * @class CatalogEntryCatalogMetadataForm
*/

import('lib.pkp.classes.form.Form');

class AdditionalTabForm extends Form {

	/** @var $_monograph Monograph The monograph used to show metadata information */
	var $_monograph;

	/** @var $_publishedMonograph PublishedMonograph The published monograph associated with this monograph */
	var $_publishedMonograph;

	/** @var $_stageId int The current stage id */
	var $_stageId;

	/** @var $_userId int The current user ID */
	var $_userId;

	/** @var $_stageId int The current stage id */
	var $_tab;

	/** @var $_userId int The current user ID */
	var $_tabPos;

	/**
	 * Parameters to configure the form template.
	 */
	var $_formParams;

	/**
	 * Constructor.
	 * @param $monographId integer
	 * @param $userId integer
	 * @param $stageId integer
	 * @param $formParams array
	 */
	function AdditionalTabForm($monographId, $userId, $stageId = null, $formParams = null) {

		parent::Form('../plugins/generic/catalogEntryTab/templates/tabContent.tpl');

		$monographDao = DAORegistry::getDAO('MonographDAO');
		$this->_monograph = $monographDao->getById($monographId);

		$this->_stageId = $stageId;
		$this->_userId = $userId;
		$this->_formParams = $formParams;

	}

	/**
	 * Fetch the HTML contents of the form.
	 * @param $request PKPRequest
	 * return string
	 */
	function fetch($request) {

		$monograph = $this->getMonograph();

		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('submissionId', $this->getMonograph()->getId());
		$templateMgr->assign('stageId', $this->getStageId());
		$templateMgr->assign('tab', $this->getTab());
		$templateMgr->assign('tabPos', $this->getTabPos());
		$templateMgr->assign('formParams', $this->getFormParams());

		$catalogEntryTabDAO = DAORegistry::getDAO('CatalogEntryTabDAO');
		$templateMgr->assign('softcover', $catalogEntryTabDAO->getLink($this->getMonograph()->getId(),'softcover'));
		$templateMgr->assign('hardcover', $catalogEntryTabDAO->getLink($this->getMonograph()->getId(),'hardcover'));
		
		return parent::fetch($request);
	}

	function initData($args,$request) {

		$this->_tab = $args['tab'];
		$this->_tabPos = $args['tabPos'];

		$monograph = $this->getMonograph();
		$publishedMonographDao = DAORegistry::getDAO('PublishedMonographDAO');

		$this->_publishedMonograph = $publishedMonographDao->getById($monograph->getId(), null, false);
	}


	//
	// Getters and Setters
	//
	/**
	 * Get the Monograph
	 * @return Monograph
	 */
	function &getMonograph() {
		return $this->_monograph;
	}

	/**
	 * Get the PublishedMonograph
	 * @return PublishedMonograph
	 */
	function &getPublishedMonograph() {
		return $this->_publishedMonograph;
	}

	/**
	 * Get the stage id
	 * @return int
	 */
	function getStageId() {
		return $this->_stageId;
	}


	function getTab() {
		return $this->_tab;
	}

	function getTabPos() {
		return $this->_tabPos;
	}

	/**
	 * Get the extra form parameters.
	 */
	function getFormParams() {
		return $this->_formParams;
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$vars = array(
			 'softcover','hardcover',// Cover image
		);

		$this->readUserVars($vars);
	}

	/**
	 * Validate the form.
	 * @return boolean
	 */
	function validate() {

		return parent::validate();
	}

	/**
	 * Save the metadata and store the catalog data for this published
	 * monograph.
	 */
	function execute($request) {

		parent::execute();

		$monograph = $this->getMonograph();
		$submissionId = $monograph->getId();

		$catalogEntryTabDAO = DAORegistry::getDAO('CatalogEntryTabDAO');

		$linkNames = array('softcover','hardcover');
		foreach($linkNames as $linkName) {

			$link = trim($this->getData($linkName));
			$dblink = trim($catalogEntryTabDAO->getLink($submissionId,$linkName));

			if ($link=='') {
				$catalogEntryTabDAO->deleteLink($submissionId,$linkName);
			} else {
				if ($dblink) {
					$catalogEntryTabDAO->updateLink($submissionId,$linkName,$link);
				} else {
					$catalogEntryTabDAO->insertLink($submissionId,$linkName,$link);
				}
			}
		}
	}

}

?>
