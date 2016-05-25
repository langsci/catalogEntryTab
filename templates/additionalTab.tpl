{**
 * plugins/generic/catalogEntryTab/templates/additionalTab.tpl
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * template for the additional tab
 *}

<li>

	<a title="new" href=" {url router=$smarty.const.ROUTE_COMPONENT 
		component="plugins.generic.catalogEntryTab.controllers.AdditionalTabHandler"
		tab="additionalTab" op="displayTabContent" submissionId=$submissionId stageId=$stageId tabPos=$counter}">
		{translate key="plugins.generic.catalogEntryTab.additionalTab"}
	</a>

</li>

{counter} {** increment tab counter **}




