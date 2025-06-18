<template id="smp-tpl-dialog-add-revision">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>{{title}}</h3>
		<p class="dialog-pb">Give your version a memorable title. Example: "Blue Header Version"</p>
		<input type="text" name="revision-title" placeholder="Version title">
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="revisions" data-action="add" data-id="{{id}}">Add</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-revision">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>{{title}}</h3>
		<p>Are you sure you want to delete this version?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="revisions" data-action="delete" data-id="{{id}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-dialog-rename-revision">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>{{title}}</h3>
		<input type="text" name="revision-title" placeholder="Version title">
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="revisions" data-action="rename" data-id="{{id}}">Rename</button>
	</div>
</template>

<template id="smp-tpl-dialog-unsaved-revision">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>{{title}}</h3>
		<p>Do you want to save your progress to the active version before continuing?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="revisions" data-action="forceLoad" data-revision-id="{{id}}">Cancel</button>
		<button class="click-handler confirm" data-handler="savePost" data-mode="draft" data-change-status="no" data-revision="{{id}}">Save</button>
	</div>
</template>