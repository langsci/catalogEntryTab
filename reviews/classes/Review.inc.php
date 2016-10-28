<?php

/**
 * @file plugins/generic/catalogEntryTab/reviews/classes/Review.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class Review
 * Data object representing an unregistered user.
 */

class Review extends DataObject {
	/**
	 * Constructor
	 */
	function Review() {
		parent::DataObject();
	}

	//
	// Get/set methods
	//

	function getSubmissionId(){
		return $this->getData('submissionId');
	}

	function setSubmissionId($submissionId) {
		return $this->setData('submissionId', $submissionId);
	}

	function setReviewer($reviewer) {
		return $this->setData('reviewer', $reviewer);
	}

	function getReviewer() {
		return $this->getData('reviewer');
	}



	function setDate($date) {
		return $this->setData('date', $date);
	}

	function getDate() {
		return $this->getData('date');
	}



	function setMoneyQuote($moneyQuote) {
		return $this->setData('moneyQuote', $moneyQuote);
	}

	function getMoneyQuote() {
		return $this->getData('moneyQuote');
	}


	function setLink($link) {
		return $this->setData('link', $link);
	}

	function getLink() {
		return $this->getData('link');
	}


	function setLinkName($linkName) {
		return $this->setData('linkName', $linkName);
	}

	function getLinkName() {
		return $this->getData('linkName');
	}

}

?>
