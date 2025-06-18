<template id="smp-tpl-dialog-delete-animation">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>Delete Animation</h3>
		<p>This will delete the timeline for this content. Are you sure?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="animation" data-action="delete" data-id="{{id}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-animate-preset">
	<div id="semplice-dialog" class="dialog keep-ep">
		<div class="inner">
			<div class="content">
				<div class="type {{type}}"></div>
				<h3>Delete global preset</h3>
				<p>Are you sure you want to delete this global preset? All animations that uses this preset will be no longer connected to it.</p>
			</div>
			<div class="footer">
				<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
				<button class="click-handler delete confirm" data-handler="run" data-action-type="animatePresets" data-action="delete" data-preset="{{presetId}}" data-id="{{id}}">Delete</button>
			</div>
		</div>
	</div>
</template>

<template id="smp-tpl-dialog-save-animate-preset">
	<div id="semplice-dialog" class="dialog keep-ep">
		<div class="inner">
			<div class="content">
				<div class="type {{type}}"></div>
				<h3>Save as preset</h3>
				<p class="dialog-pb">This will save your animation in a custom preset.</p>
				<option-input>
					<input type="text" data-name="preset-name" placeholder="Preset name">
				</option-input>
			</div>
			<div class="footer">
				<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
				<button class="click-handler" data-button-color="yellow" data-handler="run" data-action-type="animatePresets" data-action="save" data-id="{{id}}">Save</button>
			</div>
		</div>
	</div>
</template>

<template id="smp-tpl-dialog-animate-reset">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>Reset Custom Animations</h3>
		<p>Are you sure you want to remove all custom animations for this page or project?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="animate" data-action="resetAll">Delete</button>
	</div>
</template>

<template id="smp-tpl-dialog-animate-bulk-apply">
	<div class="content">
		<div class="type {{type}}"></div>
		<h3>Bulk Apply Preset</h3>
		<p>Are you sure you want to overwrite all image module animations with the selected preset?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="animate" data-action="bulkApply">Apply</button>
	</div>
</template>