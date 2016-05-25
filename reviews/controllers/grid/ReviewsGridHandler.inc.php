<?php

/**
 * @file plugins/generic/catalogEntryTab/reviews/controllers/grid/ReviewsGridHandler.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ReviewsGridHandler
 *
 */

import('lib.pkp.classes.controllers.grid.GridHandler');
import('plugins.generic.catalogEntryTab.reviews.controllers.grid.ReviewsGridRow');
import('plugins.generic.catalogEntryTab.reviews.controllers.grid.ReviewsGridCellProvider');
import('plugins.generic.catalogEntryTab.reviews.classes.ReviewsDAO');

class ReviewsGridHandler extends GridHandler {

	static $plugin;

	var $submissionId;

	static function setPlugin($plugin) {
		self::$plugin = $plugin;
	}

	/**
	 * Constructor
	 */
	function ReviewsGridHandler() {

		$test = $this->getRequestArgs();

		parent::GridHandler();
		$this->addRoleAssignment(
			array(ROLE_ID_MANAGER),
			array('addReview', 'editReview', 'updateReview', 'delete')
		);
	} 

	//
	// Overridden template methods
	//
	/**
	 * @copydoc Gridhandler::initialize()
	 */
	function initialize($request, $args = null) {

		$submissionId = $request->getUserVar('submissionId');
		parent::initialize($request);

		// Set the grid details.
		$this->setTitle('plugins.generic.catalogEntryTab.reviews.title');
		$this->setEmptyRowText('plugins.generic.catalogEntryTab.reviews.noneCreated');

		$reviewsDao = new ReviewsDAO();

		$this->setGridDataElements($reviewsDao->getBySubmissionId($submissionId));

		// Add grid-level actions
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$this->addAction(
			new LinkAction(
				'addReview',
				new AjaxModal(
					$router->url($request, null, null, 'addReview',null,array('submissionId'=>$submissionId)),
					__('plugins.generic.catalogEntryTab.reviews.addReview'),
					'modal_add_item'
				),
				__('plugins.generic.catalogEntryTab.reviews.addReview'),
				null,
				__('plugins.generic.catalogEntryTab.reviews.tooltip.addReview')
			)
		);

		// Columns
		$cellProvider = new ReviewsGridCellProvider();

		$this->addColumn(new GridColumn(
			'linkName',
			'plugins.generic.catalogEntryTab.reviews.linkName',
			null,
			'controllers/grid/gridCell.tpl', // Default null not supported in OMP 1.1
			$cellProvider
		));

		$this->addColumn(new GridColumn(
			'reviewer',
			'plugins.generic.catalogEntryTab.reviews.reviewer',
			null,
			'controllers/grid/gridCell.tpl', // Default null not supported in OMP 1.1
			$cellProvider
		));

		$this->addColumn(new GridColumn(
			'date',
			'plugins.generic.catalogEntryTab.reviews.date',
			null,
			'controllers/grid/gridCell.tpl', // Default null not supported in OMP 1.1
			$cellProvider
		));


	}

	//
	// Overridden methods from GridHandler
	//

	/**
	 * @copydoc Gridhandler::getRowInstance()
	 */
	function getRowInstance() {
		return new ReviewsGridRow($this->submissionId);
	}

	/**
	 * An action to add a new user
	 * @param $args array Arguments to the request
	 * @param $request PKPRequest Request object
	 */
	function addReview($args, $request) {

		return $this->editReview($args, $request);
	}

	/**
	 * An action to edit a user
	 * @param $args array Arguments to the request
	 * @param $request PKPRequest Request object
	 * @return string Serialized JSON object
	 */
	function editReview($args, $request) {

		$reviewId = $request->getUserVar('reviewId');
		$submissionId = $request->getUserVar('submissionId');
		$this->setupTemplate($request);

		// Create and present the edit form
		import('plugins.generic.catalogEntryTab.reviews.controllers.grid.form.ReviewForm');
		$reviewForm = new ReviewForm(self::$plugin, $submissionId, $reviewId);
		$reviewForm->initData();
		$json = new JSONMessage(true, $reviewForm->fetch($request));
		return $json->getString();
	}

	/**
	 * Update a user
	 * @param $args array
	 * @param $request PKPRequest
	 * @return string Serialized JSON object
	 */
	function updateReview($args, $request) {

		$reviewId = $request->getUserVar('reviewId');
		$submissionId = $request->getUserVar('submissionId');
		$this->setupTemplate($request);

		// Create and populate the form
		import('plugins.generic.catalogEntryTab.reviews.controllers.grid.form.ReviewForm');
		$reviewForm = new ReviewForm(self::$plugin,$submissionId, $reviewId);
		$reviewForm->readInputData();

		// Check the results
		if ($reviewForm->validate()) {
			// Save the results
			$reviewForm->execute();
 			return DAO::getDataChangedEvent();
		} else {
			// Present any errors
			$json = new JSONMessage(true, $reviewForm->fetch($request));
			return $json->getString();
		}
	}

	function fetchGrid($args, $request) {
		return parent::fetchGrid($args, $request) ;
	}

	/**                               
	 * @param $args array
	 * Delete a user
	 * @param $request PKPRequest
	 * @return string Serialized JSON object
	 */
	function delete($args, $request) {

		$reviewId = $request->getUserVar('reviewId');

		$reviewsDao = new ReviewsDAO();
		$review = $reviewsDao->getById($reviewId);

		$reviewsDao->deleteObject($review);

		return DAO::getDataChangedEvent();
	}

}

?>
