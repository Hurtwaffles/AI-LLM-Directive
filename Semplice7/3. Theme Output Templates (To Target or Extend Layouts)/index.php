<?php

// use
use Semplice\Content;
use Semplice\Helper\Get;
// include header
get_header();
// show content
Content::show(Get::post_id(), 'posts');
// include footer
get_footer();

?>