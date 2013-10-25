Control: WordPress Theme 
========================

A WordPress theme toolkit
-------------------------------------

This is a collection of theme development snippets, files and tools which I commonly reuse from project to project. I treat this theme as my 'control' sample from which take bits and pieces for use in building client sites. 

Use them, abuse them, criticise them, or not.

I aim to keep the files structured in the most manageable way, and I have embraced the concept of 'partials' - breaking up larger files into smaller partial files which group together related code.

 - /scss/ contains SASS partials
 - /includes/ contains partials of the functions.php file
 - /partials/ contains template partials


Latest
--------------

 - Import functions for creating dummy posts
 - Reference directory for storing documentation files
 - functions.php split up into partial files

Style features
--------------

 - SASS/Compass
 - Bootstrap (in SCSS format)
 - Bourbon SCSS mixin library
 - Font Awesome for use with Bootstrap icons


Utility features
----------------

 - Modernizr & Conditionizr
 - jQuery HoverIntent
 - jQuery Lazy Load
 - modal.js

WordPress features
------------------

 - functions.php with many well commented options
 - 'whitelabel' functions file for removing WordPress junk 
 - [googlemap] shortcode plugin for loading Google Maps API
 - editor-style.css for TinyMCE
 - embed widget plugin
 - custom post type plugin template

Front End features
------------------

 - Flexslider

functions.php features
----------------------

 - CSS auto-versioning. Automatically append timestamp of latest change to file as version number
 - Load style.css after plugin CSS via wp_head action priority
 - [youtube] shortcode (with video class for responsive resizing)
 - Typekit & Google web fonts async loading scripts with load action
 - add 'dropdown' class to nav menu for Bootstrap
 - custom excerpt length and 'read more' function
 - [button] shortcode for Bootstrap buttons
 - [break] clearfix shortcode for adding line breaks
 - optional WP custom header and background theme options
 - search form function code
 - search all taxonomies 
 - pagination function with Bootstrap style class