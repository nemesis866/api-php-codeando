// Cargamos las dependencias requeridas
var gulp = require('gulp'),
    connect = require('gulp-connect-php'),
    browserSync = require('browser-sync');
 
// Tarea para crear el servidor
gulp.task('connect-sync', function() {
  connect.server({
    base: './web',
    ini: '/etc/php/7.0/cli/php.ini'
  }, function (){
    browserSync({
      proxy: '127.0.0.1:8000'
    });
  });
 
  gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
});

// Tarea por defecto
gulp.task('default', ['connect-sync']);
