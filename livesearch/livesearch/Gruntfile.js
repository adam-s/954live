/**
 * @link http://gruntjs.com/sample-gruntfile
 * @param grunt
 */

module.exports = function (grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        ngtemplates: {
            livesearch: {
                src: 'src/app/{,*/}*.html',
                dest: '/tmp/templates.js',
                concat: 'dist/livesearch'
            }
        },
        concat: {
            options: {
                separator: '\n\n'
            },
            dist: {
                // the files to concatenate
                src: [
                    'src/app/app.js',
                    'src/app/**/*.js',
                    '<%= ngtemplates.livesearch.dest %>'
                ],
                dest: 'dist/livesearch.js'
            },
            vendor: {
                // the files to concatenate
                src: [
                    'src/bower_components/angular/angular.js',
                    'src/bower_components/angucomplete-alt/angucomplete-alt.js',
                    'src/bower_components/angular-youtube-mb/src/angular-youtube-embed.js'
                ],
                dest: 'dist/vendor.js'
            }
        },
        uglify: {
            dist: {
                files: {
                    'dist/livesearch.min.js': ['dist/livesearch.js']
                }
            },
            vendor: {
                files: {
                    'dist/vendor.min.js': ['dist/vendor.js']
                }
            }
        },
        watch: {
            all: {
                files: ['src/**/*', 'Gruntfile.js'],
                tasks: ['build']
            },
            dev: {
                files: ['src/**/*', 'Gruntfile.js'],
                tasks: ['build-dev']
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-angular-templates');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('build', ['ngtemplates', 'concat', 'uglify']);
    grunt.registerTask('build-dev', ['ngtemplates', 'concat:dist']);

    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });
};