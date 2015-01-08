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
          'style.dev.css': 'scss/style.scss'
        }
      }
    },
    // Auto Prefixer
    autoprefixer: {
      options: {},
      no_dest: {
        src: 'style.dev.css',
      }
    },
    // JSHint
    jshint: {
      options: {
        strict: false,
        laxcomma: true,
        loopfunc: true,
        evil: true // suppresses 'eval can be harmful' error thrown by Conditionizr IE tests
      },
      all: ['GruntFile.js', 'js/project.js']
    },
    browserSync: {
      dev: {
        bsFiles: {
          src : ['style.dev.css']
        },
        options: {
          watchTask: true,
          notify: false,
          host: '192.168.1.15',
          proxy: "dev.control"
        }
      }
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
              cwd: 'images/svg',
              src: ['**/*.svg'],
              dest: 'images/svg',
              ext: '.min.svg'
          }]
      }
    },
    grunticon: {
      icons: {
        files: [{
          expand: true,
          cwd: 'images/source',
          src: ['*.svg', '*.png'],
          dest: "images/output"
        }],
        options: {
        }
      }
    },
    cssmin: {
      minify: {
        options: {
          banner: '/*updated '+ new Date() +' */'
        },
        files: {
          'style.css': ['style.dev.css']
        }
      }
    },
    concat: {
      options: {
      },
      basic: {
        src: [
          'js/modernizr.min.js',
          'js/conditionizr.min.js',
          'js/lazyload.js',
          'js/jquery.instagram.min.js',
          'js/utilities.js',
          'js/project.js'
        ],
        dest: 'js/concat.js'
      }
    },
    uglify: {
      my_target: {
        files: {
          'js/project.min.js': 'js/concat.js'
        }
      }
    }
  });

  // Plugins
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.loadNpmTasks('grunt-browser-sync');
  grunt.loadNpmTasks('grunt-svgmin');
  grunt.loadNpmTasks('grunt-grunticon');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-newer');

  // Tasks
  grunt.registerTask('default', ['browserSync','watch']);
  grunt.registerTask('css', ['sass']);
  grunt.registerTask('prefix', ['autoprefixer']);
  grunt.registerTask('build', ['cssmin','newer:concat','newer:uglify']);

};
