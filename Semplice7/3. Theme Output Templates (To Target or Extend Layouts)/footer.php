<?php

// use
use Semplice\Admin\Customize;
use Semplice\Helper\Get;
// photoswipe
get_template_part('partials/photoswipe', 'standard');
// back to top arrow
Get::back_to_top();
// custom cursor
Customize::$setting['cursor']->get('output');
// footer
wp_footer();
?>
	</body>
</html>