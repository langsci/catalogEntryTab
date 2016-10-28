{**
 * plugins/generic/catalogEntryTab/reviews/templates/editReviewForm.tpl
 *
 * Copyright (c) 2016 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 *}

<script type="text/javascript">
	$(function() {ldelim}
		// Attach the form handler.
		$('#reviewForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

{url|assign:actionUrl router=$smarty.const.ROUTE_COMPONENT component="plugins.generic.catalogEntryTab.reviews.controllers.grid.ReviewsGridHandler" op="updateReview" submissionId=$submissionId escape=false}

<form class="pkp_form" id="reviewForm" method="post" action="{$actionUrl}">

	{if $reviewId}
		<input type="hidden" name="reviewId" value="{$reviewId|escape}" />
	{/if}
	{if $submissionId}
		<input type="hidden" name="submissionId" id="submissionId" value="{$submissionId|escape}" />
	{/if}

	{fbvFormArea id="reviewsFormArea" class="border"}

		{fbvFormSection}
			{fbvElement type="text" label="plugins.generic.catalogEntryTab.reviews.linkName" id="linkName" value=$linkName required="true" inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection}
			{fbvElement type="text" label="plugins.generic.catalogEntryTab.reviews.link" id="link" value=$link required="true" maxlength="50" inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection}
			{fbvElement type="text" label="plugins.generic.catalogEntryTab.reviews.reviewer" id="reviewer" value=$reviewer maxlength="50" inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection}
			{fbvElement type="text" label="plugins.generic.catalogEntryTab.reviews.lable.date" id="date" value=$date maxlength="50" inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection}
			{fbvElement type="textarea" label="plugins.generic.catalogEntryTab.reviews.moneyQuote" id="moneyQuote" value=$moneyQuote inline=true multilingual=false size=$fbvStyles.size.MEDIUM}
		{/fbvFormSection}

		{fbvFormSection class="formButtons"}
			{fbvElement type="submit" class="submitFormButton" id="saveButton" label="common.save"}
		{/fbvFormSection}

	{/fbvFormArea}

</form>
<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
