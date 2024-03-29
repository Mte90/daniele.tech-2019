// Defining requirements
import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import imagemin from 'gulp-imagemin';
import del from 'del';
import webpack from 'webpack-stream';
import browserSync from "browser-sync";
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const PRODUCTION = yargs.argv.prod;
const server = browserSync.create();
const sass = require('gulp-sass')(require('sass'));

// Configuration file to keep your code DRY
var cfg = require( './gulpconfig.json' );
var paths = cfg.paths;

export const styles = () => {
  return src([paths.devscss + 'theme.scss', paths.devscss + 'custom-editor-style.scss'])
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([ autoprefixer ]))
    .pipe(cleanCss({compatibility:'ie9'}))
    .pipe(dest(paths.css))
    .pipe(server.stream());
}

export const watchForChanges = () => {
    watch( paths.devscss+ '**/*.scss', styles);
    watch( paths.imgsrc + '**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch('src/js/**/*.js', series(scripts, reload));
    watch("**/*.php", reload);
}

export const images = () => {
  return src(paths.imgsrc +'**/*.{jpg,jpeg,png,svg,gif}')
    .pipe(gulpif(PRODUCTION, imagemin()))
    .pipe(dest(paths.img));
}


export const copyAssets = (done) => {
  src(paths.node + 'bootstrap/js/dist/*.js')
  .pipe(dest(paths.devjs + 'bootstrap4'));

  src(paths.node + 'bootstrap/scss/**/*.scss')
  .pipe(dest(paths.devscss + 'bootstrap4'));

	src( paths.node + 'undescores-for-npm/sass/media/*.scss')
		.pipe(dest(paths.devscss + 'underscores'));

	src(paths.node + 'undescores-for-npm/js/skip-link-focus-fix.js')
		.pipe(dest(paths.devjs));

	done();
}

export const clean = () => del(['dist']);

export const scripts = () => {
	return src(paths.devjs + 'theme.js')
		.pipe(webpack({
			module: {
				rules: [
					{
						test: /\.js$/,
						use: {
							loader: 'babel-loader',
							options: {
								presets: []
							}
						}
					}
				]
			},
			mode: PRODUCTION ? 'production' : 'development',
			devtool: !PRODUCTION ? 'inline-source-map' : false,
			optimization: {
				minimize: true,
				minimizer: [new UglifyJsPlugin({
					include: /\.js$/
				})
				]
			},
			output: {
				filename: 'theme.js'
			},
			externals: {
				jquery: 'jQuery'
			},
		}))
		.pipe(dest(paths.js));
}

export const serve = done => {
	server.init(
		cfg.browserSyncWatchFiles,
		cfg.browserSyncOptions );
	done();
};

export const reload = done => {
	server.reload();
	done();
};

export const dev = series(parallel(styles, images, scripts), serve, watchForChanges);
export const build = series(clean, parallel(styles, images, scripts));

export default dev;
