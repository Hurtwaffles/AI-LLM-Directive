<template id="smp-tpl-dialog-import-cover">
	<div class="content">
		<h3>{{title}}</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="helper" data-setting-type="cover" data-action="import" data-post-id="{{id}}">Import</button>
	</div>
</template>

<template id="smp-tpl-dialog-reset-cover">
	<div class="content">
		<h3>{{title}}</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="helper" data-setting-type="cover" data-action="reset">Reset</button>
	</div>
</template>