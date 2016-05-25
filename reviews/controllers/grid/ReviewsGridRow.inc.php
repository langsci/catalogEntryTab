<?php

/**
 * @file plugins/generic/catalogEntryTab/reviews/controllers/grid/ReviewsGridRow.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ReviewsGridRow
 *
 */

import('lib.pkp.classes.controllers.grid.GridRow');

class ReviewsGridRow extends GridRow {


	var $submissionId;
	/**
	 * Constructor
	 */
	function ReviewsGridRow($submissionId) {
		$this->submissionId=$submissionId;
		parent::GridRow();
	}

	//
	// Overridden template methods
	//
	/**
	 * @copydoc GridRow::initialize()
	 */
	function initialize($request, $template = null) {

		parent::initialize($request, $template);

		$reviewId = $this->getId();
		$submissionId = $this->getId();
		if (!empty($reviewId)) {
			$router = $request->getRouter();

			// Create the "edit user" action
			import('lib.pkp.classes.linkAction.request.AjaxModal');
			$this->addAction(
				new LinkAction(
					'editReview',
					new AjaxModal(
						$router->url($request, null, null, 'editReview', null, array('reviewId' => $reviewId,'submissionId' => $submissionId)),
						__('grid.action.edit'),
						'modal_edit',
						true),
					__('grid.action.edit'),
					null,
					__('plugins.generic.catalogEntryTab.reviews.tooltip.editReview')
				)
			);

			// Create the "delete user" action
			import('lib.pkp.classes.linkAction.request.RemoteActionConfirmationModal');
			$this->addAction(
				new LinkAction(
					'delete',
					new RemoteActionConfirmationModal(
						__('common.confirmDelete'),
						__('grid.action.delete'),
						$router->url($request, null, null, 'delete', null, array('reviewId' => $reviewId,'submissionId' => $submissionId)), 'modal_delete'
					),
					__('grid.action.delete'),
					'delete'
				)
			);
		}
	}
}

?>
