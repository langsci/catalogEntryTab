Key data
============

- name of the plugin: Catalog Entry Tab Plugin
- author: Carola Fanselow
- current version: 1.0
- tested on OMP version: 1.2
- github link: https://github.com/langsci/catalogEntryTab.git
- community plugin: no
- date: 2016/05/22

Description
============

This plugin adds a tab called "Links" to the Catalog Entry Form to enter additional data. 

1. Links to where softcover and hardcover can be bought. 
2. Data about addtional reviewers including reviewer's name, the review's link, link name, submission data and money quote

 
Implementation
================

Hooks
-----
- used hooks: 2

		Templates::Controllers::Modals::SubmissionMetadata::CatalogEntryTabs::Tabs
		LoadComponentHandler

New pages
------
- new pages: 1

		tab in catalog entry

Templates
---------
- templates that substitute other templates: 0
- templates that are modified with template hooks: 1

		templates/controllers/modals/submissionMetadata/catalogEntryTabs.tpl

- new/additional templates: 3

		additionalTab.tpl
		tabContent.tpl
		editReviewForm.tpl

Database access, server access
-----------------------------
- reading access to OMP tables: 0
- writing access to OMP tables: 0
- new tables: 2

		langsci_review_links
		langsci_submission_links

- nonrecurring server access: yes

		creating database table during installation (file: schema.xml)

- recurring server access: no
 
Classes, plugins, external software
-----------------------
- OMP classes used (php): 13
	
		GenericPlugin
		DAO
		DataObject
		GridHandler
		GridRow
		GridCellProvider
		GridComlumn
		Form
		LinkAction
		AjaxModal
		PublicationEntryTabHandler
		JSONMessage
		NotificationManager

- OMP classes used (js, jqeury, ajax): 2

		AjaxFormHandler
		PublicationFormatMetadataFormHandler

- necessary plugins: 0
- optional plugins: 0
- use of external software: no
- file upload: no
 
Metrics
--------
- number of files 22
- number of lines: 1834

Settings
--------
- settings: no

Plugin category
----------
- plugin category: generic

Other
=============
- does using the plugin require special (background)-knowledge?: no
- access restrictions: access restricted to admins and managers
- adds css: no


