module.exports = function(grunt) {
  // Config
  grunt.initConfig({
    // Package
    pkg: grunt.file.readJSON('package.json'),
    // Watch
    watch: {
      files: ['**/*.scss', '**/**/*.scss'],
      tasks: [
        'sass'
        , 'jshint'
        , 'autoprefixer'
      ],
      options: {
        livereload: true
      }
    },
    // SASS
    sass: {
      compile: {
        files: {
          'style.css': 'scss/style.scss'
        }
      }
    },
    // Auto Prefixer
    autoprefixer: {
      options: {},
      no_dest: {
        src: 'style.css',
      }
    },
    // JSHint
    jshint: {
      options: {
        strict: false,
        laxcomma: true,
        evil: true // suppresses 'eval can be harmful' error thrown by Conditionizr IE tests
      },
      all: ['GruntFile.js', 'js/project.js']
    },
    svgmin: {
      options: {
          plugins: [{
              removeViewBox: false
          }, {
              removeUselessStrokeAndFill: false
          }, {
              convertPathData: {
                  straightCurves: false
              }
          }]
      },
      dist: {
          files: [{
              expand: true,
              cwd: 'images',
              src: ['**/*.svg'],
              dest: 'images',
              ext: '.min.svg'
          }]
      }
    },
    grunticon: {
      icons: {
        files: [{
          expand: true,
          cwd: 'images/icons/source',
          src: ['*.svg', '*.png'],
          dest: "images/icons/output"
        }],
        options: {
        }
      }
    }
  });

  // Plugins
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-svgmin');
  grunt.loadNpmTasks('grunt-grunticon');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-autoprefixer');

  // Tasks
  grunt.registerTask('default', ['watch', 'jshint', 'grunticon', 'svgmin']);

};
