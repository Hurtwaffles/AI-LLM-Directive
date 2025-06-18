<template id="smp-tpl-dialog-add-block">
	<div class="content">
		<h3>Save {{type}} as Block</h3>
		<p class="dialog-pb">If you choose Component, any changes you make to your component will be applied everywhere you use that component.</p>
		<div class="block-options">
			<option-input>
				<label>Block name</label>
				<input type="text" name="block-name" placeholder="Version title">
			</option-input>
			<option-input>
				<label>Category</label>
				<select name="block-category" data-input-type="select-box">
					{{options}}
				</select>
			</option-input>
			<option-input>
				<label>Block Type</label>
				<div class="toggle-button block-type-toggle" data-size="2" data-toggle-options='{"component":"Component","static":"Static"}'>
					<div class="toggle-state"></div>
					<ul>
						<li class="selected">
							<button class="toggle-option" data-name="block-type" data-input-type="toggleButton" data-val="static" data-inline="true">Static</button>
						</li>
						<li>
							<button class="toggle-option" data-name="block-type" data-input-type="toggleButton" data-val="component" data-inline="true">Component</button>
						</li>
					</ul>
				</div>
			</option-input>
		</div>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="blocks" data-action="save" data-id="{{id}}">Add</button>
	</div>
</template>

<template id="smp-tpl-dialog-unlink-block">
	<div class="content">
		<h3>Unlink from component</h3>
		<p>Unlink this {{type}} from the component so you can edit the content without modifying the component.</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="components" data-action="unlink" data-id="{{id}}">Unlink</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-block">
	<div class="content">
		<h3>Delete {{type}}</h3>
		<p>{{content}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="blocks" data-action="delete" data-block-id="{{id}}" data-component-id="{{compId}}">Delete</button>
	</div>
</template>