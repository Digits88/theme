module.exports = function(grunt) {

  grunt.registerTask('watch', [ 'watch' ]);

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

	// concat
	concat: {
		main: {
			options: {
				separator: ';'
			},
			src: ['js/src/**/*.js'],
			dest: 'js/<%= pkg.name %>.min.js'
		},
		account: {
			options: {
				separator: ';'
			},
			src: ['js/account/**/*.js'],
			dest: 'js/account.min.js'
		},
		animation: {
			options: {
				separator: ';'
			},
			src: ['js/animation/**/*.js'],
			dest: 'js/animation.min.js'
		}
	},

    // uglify
    uglify: {
        options: {
          mangle: false
        },
        js: {
          files: {
            'js/<%= pkg.name %>.min.js': ['js/<%= pkg.name %>.min.js'],
			'js/account.min.js': ['js/account.min.js'],
			'js/animation.min.js': ['js/animation.min.js']
          }
        }
      },


    // LESS CSS
    less: {
      style: {
        options: {
          compress: true
        },
        files: {
          "style.css": "less/style.less"
        }
      }
    },


    svgstore: {
      options: {
        prefix : 'icon-', // This will prefix each <g> ID
         svg : {
            'xmlns:sketch' : 'http://www.bohemiancoding.com/sketch/ns',
            'xmlns:dc': "http://purl.org/dc/elements/1.1/",
            'xmlns:cc': "http://creativecommons.org/ns#",
            'xmlns:rdf': "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
            'xmlns:svg': "http://www.w3.org/2000/svg",
            'xmlns': "http://www.w3.org/2000/svg",
            'xmlns:sodipodi': "http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd",
            'xmlns:inkscape': "http://www.inkscape.org/namespaces/inkscape"
        }
      },
      default : {
        files: {
            // svgs in the combined folder will be combined into the svg-defs.svg file
            // usage: <svg><use xlink:href="<?php echo get_stylesheet_directory_uri() . '/images/svg-defs.svg#icon-name-of-svg'; ?>"></use></svg>
            'images/svgs/svg-defs.svg': ['images/svgs/combined/*.svg'],
        }
      }
    },


    // Add banner to style.css
    usebanner: {
       addbanner: {
          options: {
            position: 'top',
            banner: '/*\nTheme Name: AffiliateWP\n' +
                    'Template: <%= pkg.parentTheme %>\n' +
                    'Theme URI: https://affiliatewp.com/\n' +
                    'Author: Andrew Munro\n' +
                    'Author URI: https://affiliatewp.com\n' +
                    'Description: \n' +
                    'License: GNU General Public License\n' +
                    'License URI: license.txt\n' +
                    '*/',
            linebreak: true
          },
          files: {
            src: [ 'style.css' ]
          }
        }
    },

    // watch our project for changes
    watch: {
      // JS
      js: {
        files: ['js/src/**/*.js', 'js/account/**/*.js', 'js/animation/**/*.js'],
        tasks: ['concat:main', 'concat:account', 'concat:animation', 'uglify:js'],
      },
       svgstore: {
         files: ['images/svgs/combined/*.svg'],
         tasks: ['svgstore:default']
      },
      // CSS
      css: {
        // compile CSS when any .less file is compiled in this theme and also the parent theme
        files: ['less/**/*.less', '../<%= pkg.parentTheme %>/assets/less/**/*.less'],
        tasks: ['less:style'],
      },
      // Add banner
      addbanner: {
        files: 'style.css',
         tasks: ['usebanner:addbanner'],
         options: {
          spawn: false
        }
      },

    }
  });

  // Saves having to declare each dependency
  require( "matchdep" ).filterDev( "grunt-*" ).forEach( grunt.loadNpmTasks );

  grunt.registerTask('default', ['concat', 'uglify', 'less', 'svgstore', 'usebanner' ]);
};
