<template id="smp-tpl-dialog-ml-core">
	<div class="content">
		<h3>{{title}}</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler" data-handler="run" data-action-type="dialog" data-action="close">{{button}}</button>
	</div>
</template>

<template id="smp-tpl-dialog-edit-folder">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>{{title}}</h3>
		<input type="text" name="folder-title" placeholder="My Folder" value="{{val}}">
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</a>
		<button class="click-handler confirm" data-handler="run" data-action-type="folder" data-action="{{action}}" data-id="{{id}}">{{actionTitle}} Folder</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-folder">
	<div class="content">
		<div class="type warning"></div>
		<h3>{{title}}</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</a>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="folder" data-action="delete" data-id="{{id}}">Delete Folder</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-attachment">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>{{title}}</h3>
		<p>Selected items will be permanently deleted from your site. This action can't be undone. Are you sure?</p>
	</div>
	<div class="footer">
		<button class="click-handler sml-delete-media-cancel cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</a>
		<button class="click-handler sml-delete-media-confirm delete confirm" data-handler="run" data-action-type="mediaLibrary" data-action="delete" data-id="{{id}}">Delete</button>
	</div>
</template>