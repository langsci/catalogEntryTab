<?php

/**
 * @file plugins/generic/catalogEntryTab/CatalogEntryTabPlugin.inc.php
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class CatalogEntryTabPlugin
 *
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class CatalogEntryTabPlugin extends GenericPlugin {

	function register($category, $path) {
			
		if (parent::register($category, $path)) {
			$this->addLocaleData();
			$locale = AppLocale::getLocale();
			AppLocale::registerLocaleFile($locale,'plugins/generic/catalogEntryTab/reviews/locale/'.$locale.'/locale.xml');

			if ($this->getEnabled()) {

				import('plugins.generic.catalogEntryTab.CatalogEntryTabDAO');
				$catalogEntryTabDao = new CatalogEntryTabDAO();
				DAORegistry::registerDAO('CatalogEntryTabDAO', $catalogEntryTabDao);

				HookRegistry::register('LoadComponentHandler', array($this, 'setupHandler'));
				HookRegistry::register('Templates::Controllers::Modals::SubmissionMetadata::CatalogEntryTabs::Tabs', array($this, 'addTab'));
			}
			return true;
		}
		return false;
	}

	function addTab($hookName, $args) {

		$output =& $args[2];
		$request = $this->getRequest();

		$templateMgr = TemplateManager::getManager($request);
		$output .=  $templateMgr->fetch($this->getTemplatePath() . 'additionalTab.tpl');
		   
		return false;
	}

	/**
	 * Permit requests to the plugin tab handler
	 * @param $hookName string The name of the hook being invoked &quot;
	 * @param $args array The parameters to the invoked hook
	 */
	function setupHandler($hookName, $params) {
		$component =& $params[0];
		if ($component == 'plugins.generic.catalogEntryTab.controllers.AdditionalTabHandler') {
			// Allow the grid handler to get the plugin object
			import($component);
			AdditionalTabHandler::setPlugin($this);
			return true;
		}
		if ($component == 'plugins.generic.catalogEntryTab.reviews.controllers.grid.ReviewsGridHandler') {
			// Allow the users grid handler to get the plugin object
			import($component);
			ReviewsGridHandler::setPlugin($this);
			return true;
		}

		return false;
	}

	function getDisplayName() {
		return __('plugins.generic.catalogEntryTab.displayName');
	}

	function getDescription() {
		return __('plugins.generic.catalogEntryTab.description');
	}

	/**
	 * @copydoc PKPPlugin::getTemplatePath
	 */
	function getTemplatePath() {
		return parent::getTemplatePath() . 'templates/';
	}

	function getReviewsTemplatePath() {
		return parent::getTemplatePath() . 'reviews/templates/';
	}

	function getInstallSchemaFile() {
		return $this->getPluginPath() . '/schema.xml';
	}
}

?>
