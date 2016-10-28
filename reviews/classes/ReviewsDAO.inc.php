<?php

/**
 * @file plugins/generic/catalogEntryTab/classes/ReviewsDAO.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ReviewsDAO
 */

import('lib.pkp.classes.db.DAO');
import('plugins.generic.catalogEntryTab.reviews.classes.Review');

class ReviewsDAO extends DAO {

	function ReviewsDAO() {
		parent::DAO();
	}

	function getById($reviewId) {

		$result = $this->retrieve(
			'SELECT * FROM langsci_review_links WHERE review_id ='.$reviewId
		);

		$returner = null;
		if ($result->RecordCount() != 0) {
			$returner = $this->_fromRow($result->GetRowAssoc(false));
		}
		$result->Close();
		return $returner;
	}

	function getBySubmissionId($submissionId) {
		$result = $this->retrieveRange(
			'SELECT * FROM langsci_review_links WHERE submission_id = ? ORDER BY reviewer',
			$submissionId
		);

		return new DAOResultFactory($result, $this, '_fromRow');
	}

	function insertObject($review) {

		$this->update(
			'INSERT INTO langsci_review_links (submission_id, reviewer, money_quote, date,link,link_name)
			VALUES (?,?,?,?,?,?)',
			array(
				$review->getSubmissionId(),
				$review->getReviewer(),
				$review->getMoneyQuote(),
				$review->getDate(),
				$review->getLink(),
				$review->getLinkName()
			)
		);

		$review->setId($this->getInsertId());

		return $review->getId();
	}

	function updateObject($review) {

		$this->update(
			'UPDATE	langsci_review_links
			SET submission_id = ?,
				reviewer = ?,
				money_quote = ?,
				date = ?,
				link = ?,
				link_name = ?
			WHERE	review_id = ?',
			array(
				(int) $review->getSubmissionId(),
				$review->getReviewer(),
				$review->getMoneyQuote(),
				$review->getDate(),
				$review->getLink(),
				$review->getLinkName(),
				(int) $review->getId()
			)
		);

	}

	function deleteById($reviewId) {
		$this->update(
			'DELETE FROM langsci_review_links WHERE review_id = ?',
			(int) $reviewId
		);
	}

	function deleteObject($review) {
		$this->deleteById($review->getId());
	}

	function newDataObject() {
		return new Review();
	}

	function _fromRow($row) {

		$review = $this->newDataObject();
		$review->setId($row['review_id']);
		$review->setSubmissionId($row['submission_id']);
		$review->setReviewer($row['reviewer']);
		$review->setMoneyQuote($row['money_quote']);
		$review->setDate($row['date']);
		$review->setLink($row['link']);
		$review->setLinkName($row['link_name']);

		return $review;
	}

	function getInsertId() {
		return $this->_getInsertId('langsci_reviews', 'review_id');
	}

}

?>
