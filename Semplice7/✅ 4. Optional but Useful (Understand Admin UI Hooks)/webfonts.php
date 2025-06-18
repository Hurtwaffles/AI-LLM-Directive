<template id="smp-tpl-webfonts-add-webfont">
	<ep-help></ep-help>
	<div class="content" data-is-uploaded="{{isUploaded}}">
		<h3>{{title}}</h3>
		{{options}}
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="webfonts" data-action="save" data-font-id="{{id}}">Save</button>
	</div>
</template>

<template id="smp-tpl-webfonts-add-ressource">
	<ep-help></ep-help>
	<div class="content">
		<h3>{{title}} resource</h3>
		<input type="hidden" class="is-font-setting" data-name="ressource-type" value="{{type}}">
		{{options}}
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm save-webfonts-ressource" data-handler="run" data-action-type="ressource" data-action="save">Save</button>
	</div>
</template>

<template id="smp-tpl-webfonts-remove">
	<div class="content">
		<h3>Delete {{type}}</h3>
		<p>Are you sure you want to delete this {{type}}?{{notes}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="{{actionType}}" data-action="remove" data-id="{{id}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-webfonts-remove-style">
	<div class="content">
		<h3>Delete variable style</h3>
		<p>Are you sure you want to delete this style?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="variableStyles" data-action="remove" data-font-id="{{id}}" data-style-id="{{styleId}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-webfonts-host-change">
	<div class="content">
		<h3>Update Domain</h3>
		<p>It looks like the domain for your uploaded webfonts<br />doesn't match your website domain.<br /><br /><b>Old Domain:</b> {{oldDomain}}<br /><b>New Domain:</b> {{newDomain}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="customize" data-setting-type="webfonts" data-action="hostChange" data-id="{{resId}}">Update</button>
	</div>
</template>