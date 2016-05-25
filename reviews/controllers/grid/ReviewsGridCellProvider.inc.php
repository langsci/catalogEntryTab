<?php

/**
 * @file plugins/generic/catalogEntryTab/reviews/controllers/grid/ReviewsGridCellProvider.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ReviewsGridCellProvider
 *
 */

import('lib.pkp.classes.controllers.grid.GridCellProvider');
import('lib.pkp.classes.linkAction.request.RedirectAction');

class ReviewsGridCellProvider extends GridCellProvider {

	/**
	 * Constructor
	 */
	function ReviewsGridCellProvider() {
		parent::GridCellProvider();
	}

	//
	// Template methods from GridCellProvider
	//

	/**
	 * Extracts variables for a given column from a data element
	 * so that they may be assigned to template before rendering.
	 * @param $row GridRow
	 * @param $column GridColumn
	 * @return array
	 */
	function getTemplateVarsFromRowColumn($row, $column) {
		$review = $row->getData();
		switch ($column->getId()) {
			case 'reviewer':
				// The action has the label
				return array('label' => $review->getReviewer());
			case 'moneyCode':
				// The action has the label
				return array('label' => $review->getMoneyCode());
			case 'date':
				// The action has the label
				return array('label' => $review->getDate());
			case 'link':
				// The action has the label
				return array('label' => $review->getLink());
			case 'linkName':
				// The action has the label
				return array('label' => $review->getLinkName());
		}
	}
}

?>
