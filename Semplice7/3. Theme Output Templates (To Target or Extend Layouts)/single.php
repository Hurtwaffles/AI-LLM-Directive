<?php

// use
use Semplice\Content;
use Semplice\Helper\Get;
// include header
get_header();
// show content
Content::show(Get::post_id(), 'post');
// include footer
get_footer();

?>