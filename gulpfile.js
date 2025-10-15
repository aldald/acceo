const { watch, parallel, series, src, dest } = require('gulp'),
    mode        = require('gulp-mode')();
sass        = require('gulp-sass')(require('sass')),
    autoprefixer = require('autoprefixer'),
    postcss     = require('gulp-postcss'),
    sourcemaps  = require('gulp-sourcemaps'),
    rename      = require('gulp-rename'),
    cleanCss    = require('gulp-clean-css'),
    plumber     = require("gulp-plumber"),
    uglify      = require('gulp-uglify'),
    webpack     = require('webpack-stream');
prefixCSS = require('gulp-prefix-css');


// Detect env.
const prod = process.env.NODE_ENV === 'production';

// Define asset paths.
const paths = {
    'dist': 'assets/**/*',
    'html': {
        'watch': '**/*.php'
    },
    'css': {
        'base': 'src/scss/',
        'src': 'src/scss/theme.scss',
        'dest': 'assets/css/',
        'watch': 'src/scss/**/*.scss',
    },
    'js': {
        'base': 'src/js/',
        'src': 'src/js/theme.js',
        'dest': 'assets/js/',
        'watch': 'src/js/theme.js',
    },
    'js_bo': {
        'base': 'src/js/',
        'src': 'src/js/backoffice.js',
        'dest': 'assets/js/',
        'watch': 'src/js/backoffice.js',
    },
    'fonts': {
        'dest': 'assets/fonts/',
    },
    'icons': {
        'dest': 'assets/icons/',
    }
}

function css() {
    return src(paths.css.src)
        .pipe(plumber())
        .pipe(mode.development(sourcemaps.init()))
        .pipe(sass({ outputStyle: 'expanded' }))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCss())
        .pipe(mode.development(sourcemaps.write()))
        .pipe(rename({'suffix': '.min'}))
        .pipe(dest(paths.css.dest));
}

function js() {
    return src(paths.js.src)
        .pipe(plumber())
        .pipe(webpack({
            mode: 'production',
            devtool:false,
            output: {
                filename: 'theme.js',
            },
            module: {
                rules: [{
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }]
            }
        }))
        .pipe(uglify())
        .pipe(rename({
            'suffix': '.min',
        }))
        .pipe(dest(paths.js.dest))
}

function js_bo() {
    return src(paths.js_bo.src)
        .pipe(plumber())
        .pipe(webpack({
            mode: prod ? 'production' : 'development',
            devtool: prod ? false : 'eval',
            output: {
                filename: 'backoffice.js',
            },
            module: {
                rules: [{
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }]
            }
        }))
        .pipe(uglify())
        .pipe(rename({
            'suffix': '.min',
        }))
        .pipe(dest(paths.js.dest))
}

function watchFiles() {
    watch(paths.js.watch, series(js));
    watch(paths.js_bo.watch, series(js_bo));
    watch(paths.css.watch, series(css,prefix));
}

// Prefix theme.css with a class .acfe-fc-preview to prevent conflict in Wordpress ACF builder
function prefix(){
    return src(paths.css.dest + '/theme.min.css')
        .pipe(prefixCSS('.acfe-fc-preview'))
        .pipe( rename('bo-render.css'))
        .pipe(dest(paths.css.dest));
}

function copy_boostrap_icons_fonts(){
    return src('node_modules/bootstrap-icons/font/fonts/*')
        .pipe(dest(paths.fonts.dest));
}

function copy_boostrap_icons_svg(){
    return src('node_modules/bootstrap-icons/icons/*')
        .pipe(dest(paths.icons.dest));
}

exports.css = css;
exports.js = js;
exports.prefix = prefix;
exports.fonts = copy_boostrap_icons_fonts;
exports.icons = copy_boostrap_icons_svg;
exports.build = series(css,prefix,js,js_bo,copy_boostrap_icons_fonts,copy_boostrap_icons_svg);
exports.watch = series(css,prefix,js,js_bo,watchFiles);