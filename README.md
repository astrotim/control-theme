Control
========================

A WordPress theme toolkit
-------------------------------------

This is a collection of theme development snippets, files and tools which I commonly reuse from project to project. I treat this theme as my 'control' sample from which I take bits and pieces for use in building client sites.

Use them, abuse them, improve them, or not.

I aim to keep the files structured in the most manageable way, and I have embraced the concept of 'partials' - breaking up larger files into smaller partial files which group together related code.

 - /scss/ contains Sass partials
 - /functions/ contains partials of the functions.php file
 - /includs/ contains additional config files
 - /partials/ contains template partials
 - /acf/ contains Advanced Custom Fields files for each registered field group


Jan 2015
--------------

 - reorganised functions.php partial files in /functions/ directory
 - reorganised /scss/ into sub directories
 - updates /js/ libraries and plugins
 - better structure and commenting in project.js
 - implemented development file structure for CSS and JS with Grunt build process to concatenate and minify for production
 - removed a bunch of bloat


May 2014
--------------

 - Added GruntJS tasks for compiled Sass with libsass, autoprefixer and JS Hint
 - Added /acf/ directory for organising Advanced Custom Fields field groups
 - Import functions for creating dummy posts
 - Reference directory for storing documentation files
 - functions.php split up into partial files

