const gulp = require('gulp');
const concat = require('gulp-concat');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');

// Chemins des fichiers CSS et JS
const paths = {
    styles: [
        'public/css/style.css',
    ],
    scripts: [
        'public/js/app.js',
        'public/js/custom.js',
        'public/js/grid.custom.js',
        'public/js/magnetCurs.js',
        'public/js/masonry.custom.js'
    ],
    menuScript: 'public/js/menu.js', // Chemin de menu.js
};

// Tâche pour concaténer et minifier les CSS
gulp.task('styles', () => {
    return gulp.src(paths.styles)
        .pipe(sourcemaps.init())
        .pipe(concat('all-styles.min.css'))
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/css/minified'));
});

// Tâche pour concaténer et minifier les JS
gulp.task('scripts', () => {
    return gulp.src(paths.scripts)
        .pipe(sourcemaps.init())
        .pipe(concat('all-scripts.min.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/js/minified'));
});

// Tâche pour minifier menu.js séparément
gulp.task('menu', () => {
    return gulp.src(paths.menuScript)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(concat('menu.min.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/js/minified'));
});

// Tâche par défaut
gulp.task('default', gulp.series('styles', 'scripts', 'menu'));
