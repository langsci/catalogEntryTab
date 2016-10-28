<?php

/**
 * @file plugins/generic/catalogEntryTab/reviews/controllers/grid/form/ReviewForm.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ReviewForm
 *
 */

import('lib.pkp.classes.form.Form');

class ReviewForm extends Form {

	var $submissionId;

	var $reviewId;

	var $plugin;

	/**
	 * Constructor
	 */
	function ReviewForm($catalogEntryTabPlugin, $submissionId, $reviewId=null) {

		parent::Form($catalogEntryTabPlugin->getReviewsTemplatePath() . 'editReviewForm.tpl');

		$this->submissionId = $submissionId;
		$this->reviewId = $reviewId;
		$this->plugin = $catalogEntryTabPlugin;

		// Add form checks
		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidator($this,'linkName','required', 'plugins.generic.catalogEntryTab.reviews.reviewerRequired'));

		$this->addCheck(new FormValidatorCustom(
				$this, 'date', 'optional', 'plugins.generic.catalogEntryTab.reviews.dateFormat',
				create_function(
						'$date,$form',
						'if (ctype_digit($date)&&strlen($date)==8) return true;
						return false;'),
				array(&$this)
		));

		$this->addCheck(new FormValidatorCustom(
				$this, 'link', 'required', 'plugins.generic.catalogEntryTab.reviews.urlFormat',
				create_function(
						'$link,$form',
						'if (!filter_var($link, FILTER_VALIDATE_URL) === false) {return true;} else {return false;}'),
				array(&$this)
		));

	}

	/**
	 * Initialize form data
	 */
	function initData() {

		if ($this->reviewId) {
			$reviewsDao = new ReviewsDAO();
			$review = $reviewsDao->getById($this->reviewId);

			$this->setData('submissionId', $review->getSubmissionId());
			$this->setData('reviewer', $review->getReviewer());
			$this->setData('moneyQuote', $review->getMoneyQuote());
			$this->setData('date', $review->getDate());
			$this->setData('link', $review->getLink());
			$this->setData('linkName', $review->getLinkName());
		}
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array('reviewer','moneyQuote','date','link','linkName','submissionId'));
	}

	/**
	 * @see Form::fetch
	 */
	function fetch($request) {

		$templateMgr = TemplateManager::getManager();
		$templateMgr->assign('reviewId', $this->reviewId);
		$templateMgr->assign('submissionId', $this->submissionId);

		return parent::fetch($request);
	}

	/**
	 * Save form values into the database
	 */
	function execute() {

		$reviewsDao = new ReviewsDAO();
		if ($this->reviewId) {
			// Load and update an existing review
			$review = $reviewsDao->getById($this->reviewId);
		} else {
			// Create a new review
			$review = $reviewsDao->newDataObject();
		}
		$review->setSubmissionId($this->getData('submissionId'));
		$review->setReviewer($this->getData('reviewer'));
		$review->setMoneyQuote($this->getData('moneyQuote'));
		$review->setDate($this->getData('date'));
		$review->setLink($this->getData('link'));
		$review->setLinkName($this->getData('linkName'));

		if ($this->reviewId) {
			$reviewsDao->updateObject($review);
		} else {
			$reviewsDao->insertObject($review);
		}

	}
}

?>
