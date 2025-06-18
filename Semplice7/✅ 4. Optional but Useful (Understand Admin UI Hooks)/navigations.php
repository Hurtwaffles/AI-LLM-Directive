<template id="smp-tpl-dialog-delete-menu">
	<div class="content">
		<h3>Delete Menu</h3>
		<p>You are about to permanently delete this menu. Are you sure?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="menu" data-action="remove" data-menu-id="{{id}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-navigation">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>Delete Navigation</h3>
		<p>Are you sure you want to delete this navigation?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="customize" data-setting-type="navigations" data-action="deleteNav" data-nav-id="{{id}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-nav-element">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>Delete content</h3>
		<p>Are you sure you want to delete this content?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="remove" data-remove-type="navElement" data-name="navElement" data-id="{{id}}">Delete</button>
	</div>
</template>