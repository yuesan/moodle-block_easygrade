module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        bower: {
            install: {
                options: {
                    targetDir: './',
                    layout: function (type) {
                        if (type === 'css') {
                            return 'css';
                        }
                        else if (type === 'fonts') {
                            return 'fonts';
                        } else {
                            return 'js';
                        }
                    },
                    install: true,
                    verbose: true,
                    cleanTargetDir: false,
                    cleanBowerDir: true
                }
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-bower-task');

    grunt.registerTask('default', ['bower']);
};