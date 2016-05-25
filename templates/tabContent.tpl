{**
 * plugins/generic/catalogEntryTab/templates/tabContent.tpl
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * template for the content of the additional tab
 *}

{capture assign=publicationFormId}publicationMetadataEntryForm-{$representationId}{/capture}

<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#{$publicationFormId|escape:"javascript"}').pkpHandler(
			'$.pkp.controllers.modals.catalogEntry.form.PublicationFormatMetadataFormHandler',
			{ldelim}
				trackFormChanges: true
			{rdelim}
		);
	{rdelim});
</script>

<form class="pkp_form" id="{$publicationFormId|escape}" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="saveForm"}">

	<input type="hidden" name="submissionId" value="{$submissionId|escape}" />
	<input type="hidden" name="stageId" value="{$stageId|escape}" />
	<input type="hidden" name="tabPos" value={$tabPos|escape} />
	<input type="hidden" name="displayedInContainer" value="{$formParams.displayedInContainer|escape}" />
	<input type="hidden" name="tab" value={$tab|escape} />

	<div class="pkp_helpers_clear"></div>

	{fbvFormArea id="booklinks"  class="border" title="plugins.generic.catalogEntryTab.coverlinks"}
		{fbvFormSection }
			{fbvElement label="plugins.generic.catalogEntryTab.coverlinks.soft" type="text"  name="softcover" id="softcover" value=$softcover size=$fbvStyles.size.MEDIUM} <!-- maxlength="255" size=$fbvStyles.size.SMALL inline="true" -->
			{fbvElement label="plugins.generic.catalogEntryTab.coverlinks.hard" type="text"  name="hardcover" id="hardcover" value=$hardcover size=$fbvStyles.size.MEDIUM}  <!-- maxlength="255" size=$fbvStyles.size.SMALL inline="true" -->
		{/fbvFormSection}
	{/fbvFormArea}

	{url|assign:reviewsGridUrl router=$smarty.const.ROUTE_COMPONENT component="plugins.generic.catalogEntryTab.reviews.controllers.grid.ReviewsGridHandler" op="fetchGrid" submissionId=$submissionId escape=false}
	{load_url_in_div id="reviewsGridContainer" url=$reviewsGridUrl}
	<p>{translate key="plugins.generic.catalogEntryTab.reloadInstruction"}</p>

	{fbvFormButtons id="publicationMetadataFormSubmit" submitText="common.save"}
</form>



