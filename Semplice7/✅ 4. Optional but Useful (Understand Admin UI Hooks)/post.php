<template id="smp-tpl-dialog-add-page">
	<div class="content">
		<h3>{{title}}</h3>
		<div class="post-options">
			<option-input>
				<label>Title</label>
				<input type="text" data-name="post-title" placeholder="Page title" class="is-meta">
			</option-input>
			<option-input>
				<label>Content Type</label>
				<div class="toggle-button is-meta" data-name="content_type" data-size="2" data-toggle-options='{"page":"Page","coverslider":"Coverslider"}'>
					<div class="toggle-state"></div>
					<ul>
						<li class="selected">
							<button class="toggle-option" data-name="content_type" data-input-type="toggleButton" data-val="page" data-inline="true">Page</button>
						</li>
						<li>
							<button class="toggle-option" data-name="content_type" data-input-type="toggleButton" data-val="coverslider" data-inline="true">Coverslider</button>
						</li>
					</ul>
				</div>
			</option-input>
		</div>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm add-post-button" data-handler="run" data-action-type="helper" data-setting-type="post" data-action="add" data-post-type="{{postType}}">Add</button>
	</div>
</template>

<template id="smp-tpl-dialog-add-project">
	<div class="content">
		<h3>{{title}}</h3>
		<div class="post-options">
			<option-input>
				<label>Title</label>
				<input type="text" data-name="post-title" placeholder="Page title" class="is-meta">
			</option-input>
			<option-input>
				<label>Type</label>
				<input type="text" data-name="project-type" placeholder="Corporate Design" class="is-meta">
			</option-input>
			{{upload}}
		</div>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="helper" data-setting-type="post" data-action="add" data-post-type="{{postType}}">Add</button>
	</div>
</template>

<template id="smp-tpl-dialog-add-footer">
	<div class="content">
		<h3>{{title}}</h3>
		<div class="post-options">
			<option-input>
				<label>Title</label>
				<input type="text" data-name="post-title" placeholder="Page title" class="is-meta">
			</option-input>
		</div>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm add-post-button" data-handler="run" data-action-type="helper" data-setting-type="post" data-action="add" data-post-type="footer">Add</button>
	</div>
</template>

<template id="smp-tpl-dialog-delete-post">
	<div class="content">
		<h3>Delete Post</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler delete confirm" data-handler="run" data-action-type="helper" data-setting-type="post" data-action="delete" data-delete-id="{{id}}" data-post-type="{{postType}}">Delete</button>
	</div>
</template>

<template id="smp-tpl-dialog-convert-semplice">
	<div class="content">
		<h3>{{title}}</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler confirm" data-handler="run" data-action-type="helper" data-setting-type="post" data-action="convert" data-post-id="{{postId}}">Start editing</button>
	</div>
</template>