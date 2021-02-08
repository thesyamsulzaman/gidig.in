const gulp = require("gulp");
const sass = require("gulp-sass");
const imageMin = require("gulp-imagemin");
const minify = require("gulp-minify");
const uglify = require("gulp-uglify");
const browserSync = require("browser-sync").create();

let plumber = require("gulp-plumber");
let rename = require("gulp-rename");
let concat = require("gulp-concat");

function style() {
  return (
    gulp
      .src("src/styles/**/*.scss")
      //.pipe(plumber())
      .pipe(
        sass({
          style: "compressed",
        })
      )
      .pipe(concat("style.css"))
      .pipe(gulp.dest("build/css"))
      .pipe(browserSync.stream())
  );
}
function jsMinify() {
  return gulp
    .src("src/js/**/*.js")
    .pipe(minify())
    .pipe(gulp.dest("build/scripts"))
    .pipe(browserSync.stream());
}

function imageMinify() {
  return gulp
    .src("src/images/*")
    .pipe(imageMin())
    .pipe(gulp.dest("build/images/"));
}

function watch() {
  browserSync.init({
    server: {
      baseDir: "build",
    },
  });
  //gulp.watch("src/js/**/*.js", jsMinify);
  gulp.watch("src/styles/**/*.scss", style);
  gulp.watch("src/images/*", imageMinify);
  //gulp.watch("build/*.html").on("change", browserSync.reload);
}

exports.style = style;
//exports.jsMinify = jsMinify;
exports.watch = watch;
exports.imageMinify = imageMinify;
