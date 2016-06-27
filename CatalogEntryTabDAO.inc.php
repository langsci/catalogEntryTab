<?php

/**
 * @file plugins/generic/catalogEntryTab/CatalogEntryTabDAO.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CatalogEntryTabDAO
 *
 */

class CatalogEntryTabDAO extends DAO {
	/**
	 * Constructor
	 */
	function CatalogEntryTabDAO() {
		parent::DAO();
	}

	function getLink($submission_id,$link_name) {

		$result = $this->retrieve(
			'SELECT link FROM langsci_submission_links WHERE submission_id='.$submission_id.' AND link_name="'.$link_name.'"'
		);

		if ($result->RecordCount() == 0) {
			$result->Close();
			return null;
		} else {
			$row = $result->getRowAssoc(false);
			$link = $this->convertFromDB($row['link'],null);				 
			$result->Close();
			return $link;
		}
	}

	function insertLink($submission_id,$link_name,$link) {
		$this->update(
			'INSERT INTO langsci_submission_links(submission_id,link_name,link) VALUES('.$submission_id.',"'.$link_name.'","'.$link.'")'
		);
		return true;
	}

	function updateLink($submission_id,$link_name,$link) {

		$this->update(
			'UPDATE langsci_submission_links set link="'.$link.'" WHERE submission_id= '.$submission_id.' AND link_name="'.$link_name.'"'
		);
		return true;
	}

	function deleteLink($submission_id,$link_name) {

		$this->update(
			'DELETE FROM langsci_submission_links WHERE submission_id= '.$submission_id.' AND link_name="'.$link_name.'"'
		);
		return true;
	}

}

?>
