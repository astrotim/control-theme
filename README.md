Control
========================

A WordPress theme toolkit
-------------------------------------

This is a collection of theme development snippets, files and tools which I commonly reuse from project to project. I treat this theme as my 'control' sample from which I take bits and pieces for use in building client sites.

Use them, abuse them, improve them, or not.

I aim to keep the files structured in the most manageable way, and I have embraced the concept of 'partials' - breaking up larger files into smaller partial files which group together related code.

 - /scss/ contains Sass partials
 - /includes/ contains partials of the functions.php file
 - /partials/ contains template partials
 - /acf/ contains Advanced Custom Fields files for each registered field group


Latest
--------------

 - Added GruntJS tasks for compiled Sass with libsass, autoprefixer and JS Hint
 - Added /acf/ directory for organising Advanced Custom Fields field groups
 - Import functions for creating dummy posts
 - Reference directory for storing documentation files
 - functions.php split up into partial files

Style features
--------------

 - Sass - compiled with libsass via Grunt
 - Bootstrap (in Sass format)
 - Bourbon mixin library
 - UI directory for Sass partials like buttons, lists, forms, tables, images
 - Font Awesome


Utility features
----------------

 - Modernizr & Conditionizr
 - Bootstrap JS
 - Flexslider
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

functions.php features
----------------------

 - style.css auto-versioning: automatically append timestamp of latest change to file as version number
 - Load style.css after plugin CSS via wp_head action priority
 - [youtube] shortcode (with video class for responsive resizing)
 - Typekit web fonts async loading script
 - Custom walker for WP nav to add Bootstrap drop down class
 - custom excerpt length and 'read more' function
 - optional WP custom header and background theme options
 - search form function code
 - search all taxonomies
 - pagination function with Bootstrap style class