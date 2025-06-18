<?php
	use Semplice\Helper\Get;
?>
<template id="smp-tpl-studio-gallerygrid">
	<?php echo Get::studio('gallerygrid', 'Show off your work with grids and image galleries', 'Choose from a range of customizable grids and gallery sliders to showcase your work and photos.'); ?>
</template>
<template id="smp-tpl-studio-advancedportfoliogrid">
	<?php echo Get::studio('advancedportfoliogrid', 'Present your projects in a bold, interactive way', 'Unlock the Advanced Portfolio Grid module, giving you even more visual ways to show off your work.'); ?>
</template>
<template id="smp-tpl-studio-mailchimp">
	<?php echo Get::studio('mailchimp', 'Collect email addresses for your newsletter', 'Unlock the Mailchimp module, so people can sign up for your witty emails straight from your site.'); ?>
</template>
<template id="smp-tpl-studio-blocks">
	<?php echo Get::studio('blocks', 'Save individual content elements as templates', 'Use our pre-defined layout or create your own blocks and re-use them wherever you need.'); ?>
</template>
<template id="smp-tpl-studio-beforeafter">
	<?php echo Get::studio('beforeafter', 'Show before/after comparisons of your work', 'Get the Before/After module to share your process or the impact of your work with a sliding visual comparison. Only with Studio edition.'); ?>
</template>
<template id="smp-tpl-studio-upgrade">
	<div id="semplice-dialog" class="dialog dialog-advanced{{customClass}}">
		<div class="inner">
			<div class="close-dialog">close</div>
			<div class="content">
				<h3>How to activate Studio</h3>
				<p>After you purchased the Studio Edition, you will receive an email with a new license key which you need to enable your new Studio Edition.</p>
			</div>
			<div class="footer">
				<button class="click-handler cancel" data-handler="run" data-action-type="dialog" data-action="close">Cancel</button>
				<button class="dialog-license-settings">License settings</button>
			</div>	
		</div>
	</div>
</template>