<?php
	use Semplice\Helper\Get;
	$dialog_inner = '
		<div class="inner">
			<div class="close-dialog">close</div>
			<div class="content">
				<h3>{{title}}</h3>
				<p>{{text}}</p>
			</div>
			<div class="footer">
				<button class="click-handler confirm" data-handler="run" data-action-type="dialog" data-action="close">{{button}}</button>
			</div>
		</div>
	';
	
?>
<template id="smp-tpl-dialog">
	<div id="semplice-dialog" class="dialog">
		<?php echo $dialog_inner; ?>
	</div>
</template>

<template id="smp-tpl-dialog-custom-class">
	<div id="semplice-dialog" class="dialog {{customClass}}">
		<?php echo $dialog_inner; ?>
	</div>
</template>

<template id="smp-tpl-dialog-advanced">
	<div id="semplice-dialog" class="dialog dialog-advanced{{customClass}}">
		<div class="inner">
			<div class="close-dialog">close</div>
			{{content}}
		</div>
	</div>
</template>

<template id="smp-tpl-dialog-code-editor">
	<div id="semplice-dialog" class="dialog codemirror-dialog">
		<div class="inner">
			<div class="codemirror-header">
				<div class="title">{{title}}</div>
				<div class="actions">
					<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
					<button class="click-handler save confirm" data-handler="run" data-action-type="codeEditor" data-action="save" data-type="{{type}}" data-id="{{id}}">Done</button>
				</div>
			</div>
			<textarea id="codemirror">{{code}}</textarea>
		</div>
	</div>
</template>

<template id="smp-tpl-dialog-edit-mesh">
	<div id="semplice-dialog" class="dialog mesh-dialog keep-ep">
		<div class="inner">
			<div class="mesh-header">
				<div class="title">{{title}}</div>
				<div class="actions">
					<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
					<button class="click-handler save confirm" data-handler="run" data-action-type="mesh" data-action="save">Save</button>
				</div>
			</div>
			<div id="semplice-mesh">
				<div class="mesh-preview">
					<div class="mesh-handles"></div>
				</div>
				<div class="mesh-picker-holder"></div>
				<div class="mesh-settings">
					<div class="mesh-bg-color">
						<p>Background Color</p>
						<div class="mesh-bg-color-input">
							<p>{{bgColor}}<p>
							<div class="color-picker mesh-color-picker picker_meshbgcolor" data-picker-id="picker_meshbgcolor" data-holder="mesh" data-show-color="false" data-mode="solid">
								<div class="color-preview" style="background: {{bgColor}}"></div>
								<input type="text" value="{{bgColor}}" data-input-type="color" data-type="mesh" data-sub-type="meshBgColor" data-option-id="option_meshbgcolor">
							</div>
						</div>
					</div>
					<div class="mesh-colors">
						<p>Colors</p>
						<ul></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<template id="smp-tpl-grid-sizes">
	<div class="content">
		<h3>Grid Sizes</h3>
		<div class="grid-sizes">
			<div class="grid-sizes-row">
				<div class="grid-sizes-value">
					<p>
						<span class="title">Outer</span>
						<span class="val">{{containerWidth}}</span>
					</p>
				</div>
				<div class="grid-sizes-value">
					<p>
						<span class="title">Grid</span>
						<span class="val">{{gridWidth}}</span>
					</p>
				</div>
				<div class="grid-sizes-value">
					<p>
						<span class="title">Gutter</span>
						<span class="val">{{gutterWidth}}</span>
					</p>
				</div>
			</div>
			<div class="divider"></div>
			<div class="grid-sizes-row-big">
				<?php echo Get::grid_columns(1); ?>
			</div>
			<div class="grid-sizes-row-big">
				<?php echo Get::grid_columns(5); ?>
			</div>
			<div class="grid-sizes-row-big">
				<?php echo Get::grid_columns(9); ?>
			</div>
			<div class="divider"></div>
			<p class="grid-sizes-info">The values above should be used for content like images, videos etc. If you have uneven values please change the grid or gutter size. All values are in pixel.</p>
		</div>
	</div>
	<div class="footer">
		<button class="click-handler confirm" data-handler="run" data-action-type="dialog" data-action="close">Continue Editing</button>
	</div>
</template>

<template id="smp-tpl-editor-notice">
	<div class="content">
		<h3>{{title}}</h3>
		<p>{{text}}</p>
	</div>
	<div class="footer">
		<button class="click-handler" data-handler="run" data-action-type="helper" data-setting-type="editor" data-action="markNotice" data-notice-id="{{id}}">{{button}}</button>
	</div>
</template>
<template id="smp-tpl-getting-started">
	<div class="content">
		<button class="click-handler dialog-close" data-handler="run" data-action-type="helper" data-setting-type="editor" data-action="markNotice" data-notice-id="{{id}}"><?php echo Get::svg('admin', 'close'); ?></button>
		<img src="<?php echo SEMPLICE_URI; ?>/assets/images/editor/getting-started.png">
	</div>
</template>

<template id="smp-tpl-dialog-footer-settings">
	<div class="content">
		<h3>{{title}}</h3>
		<div class="post-options">
			<option-input>
				<label>Title</label>
				<input type="text" data-name="foooter-title" placeholder="Footer title" class="footer-title" value="{{footerTitle}}">
			</option-input>
		</div>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler" data-handler="run" data-action-type="editorSave" data-action="footerSettings">Save</button>
	</div>
</template>

<template id="smp-tpl-unsaved-changes-customize">
	<div class="content">
		<h3>Unsaved Changes</h3>
		<p>Do you want to save your progress before continuing?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="helper" data-setting-type="url" data-action="triggerHashchange">Don't Save</button>
		<button class="click-handler" data-handler="saveAndContinue" data-setting="{{setting}}" data-settings-type="{{type}}" data-hashchange="yes">Save & Continue</button>
	</div>
</template>

<template id="smp-tpl-unsaved-changes-editor">
	<div class="content">
		<button class="click-handler dialog-close" data-handler="run" data-action-type="dialog" data-action="close"><?php echo Get::svg('admin', 'close'); ?></button>
		<h3>Unsaved Changes</h3>
		<p>Do you want to save your progress before continuing?</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="editor" data-action="exit" data-exit-mode="close" data-post-type="{{postType}}" data-reopen="{{reOpenUrl}}" data-new-url="{{newUrl}}">Don't Save</button>
		<button class="click-handler" data-handler="run" data-action-type="editorSave" data-action="postAndExit" data-exit-mode="close" data-post-type="{{postType}}" data-reopen="{{reOpenUrl}}" data-new-url="{{newUrl}}">Save & Exit</button>
	</div>
</template>

<template id="smp-tpl-dialog-reset-breakpoint">
	<div class="content">
		<h3>Reset Breakpoint</h3>
		<p>This will reset all changes made to the section in this breakpoint. This includes styles, options and content.</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler" data-handler="run" data-action-type="breakpoint" data-action="reset" data-id="{{id}}" data-button-color="red">Reset Changes</button>
	</div>
</template>

<template id="smp-tpl-dialog-copy-breakpoint">
	<div class="content">
		<h3>Copy changes</h3>
		<p>This will replace all changes made to the section in this breakpoint with the {{copyBp}} changes.</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler" data-handler="run" data-action-type="breakpoint" data-action="copy" data-id="{{id}}" data-from="{{from}}" data-button-color="red">Copy Changes</button>
	</div>
</template>

<template id="smp-tpl-dialog-reset-template">
	<div class="content">
		<h3>Reset Template</h3>
		<p>This will reset your template to the default version. Please note that all of your editings and additions will be gone.</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler" data-handler="run" data-action-type="customize" data-setting-type="blog" data-action="reset" data-template="{{template}}" data-button-color="red">Reset Template</button>
	</div>
</template>

<template id="smp-tpl-dialog-reset-intro">
	<div class="content">
		<h3>Reset Intro</h3>
		<p>This will reset your site intro. Please note that all of your editings and additions will be gone.</p>
	</div>
	<div class="footer">
		<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
		<button class="click-handler" data-handler="run" data-action-type="customize" data-setting-type="intro" data-action="reset" data-button-color="red">Reset Intro</button>
	</div>
</template>