const {watch, series, parallel, src, dest} = require('gulp');
const [config, fichiers, icones_fa] = require("./gulp_vars.js");

// Include Our Plugins
const _ = require('lodash');
const jshint = require('gulp-jshint');
const gulpsass = require('gulp-sass')(require('sass'));
const fiber = require('fibers')
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const cleanCSS = require('gulp-clean-css');
const gulpiconfont = require('gulp-iconfont');
const consolidate = require('gulp-consolidate');
const gulptemplate = require('gulp-template-compile');
const googleWebFonts = require('gulp-google-webfonts');
const faMinify = require('gulp-fa-minify');
const uglify = require('gulp-uglify-es').default;
const runTimestamp = Math.round(Date.now() / 1000);

var buffer = require('vinyl-buffer');
var spritesmash = require('gulp-spritesmash');
var spritesmith = require('gulp.spritesmith');


/////////////////////////////////////////////////
// Definition des tâches
/////////////////////////////////////////////////

exports.bootstrap = bootstrap;
exports.bootstrap2spip = bootstrap2spip;
exports.sass = sass;
exports.styles = styles;
exports.css = series(bootstrap, sass, styles);

exports.scripts = scripts;
exports.scripts_bas_de_page = scripts_bas_de_page;
exports.verif_js = series(lint);
exports.js = series(scripts, scripts_bas_de_page);

exports.flag = parallel(flag_sass, flag_copie);
exports.googlefonts = googlefonts;
exports.copie_fonts = copie_fonts;
exports.fonts = series(googlefonts, copie_fonts, sass);
exports.fa = series(fontawesome, scripts);
exports.typo = parallel(exports.fonts, exports.fa);

exports.templates = series(templates, scripts, scripts_bas_de_page)

exports.sprite = sprite;
exports.icons = icons;


exports.build = parallel(exports.js, exports.css);

exports.watch = function () {
    watch(config.dir + 'js/**/*.js', scripts);
    watch(config.dir + 'scss/**/*.scss', sass);
    watch(config.dir + 'html/**/*.html', templates);
};
exports.default = series(exports.build, exports.watch);


/////////////////////////////////////////////////////
// fonctions FEUILLES DE STYLES
////////////////////////////////////////////////////
function logError(err) {
    console.log(err);
    return false;
}

function compilation_sass(tab_fichier_input, rep_output, fichier_output) {
    src(tab_fichier_input)
        .pipe(gulpsass(
                {
                    includePaths: [ config.dir + 'scss/bootstrap/', config.bootstrapDir + 'scss/'],
                    fiber: fiber
                }
            ).on('error', gulpsass.logError)
        )
        .pipe(cleanCSS({compatibility: 'ie8', rebase: false}))
        .pipe(concat(fichier_output))
        .pipe(dest(rep_output));
}

function compilation_sass2spip(tab_fichier_input, rep_output, fichier_output) {
    src(tab_fichier_input)
        .pipe(gulpsass(
                {
                    includePaths: [config.dir + 'scss/',config.dir + 'scss/bootstrap2spip/', config.dir + 'scss/bootstrap/', config.bootstrapDir ],
                    fiber: fiber
                }
            ).on('error', gulpsass.logError)
        )
        .pipe(cleanCSS({compatibility: 'ie8', rebase: false}))
        .pipe(concat(fichier_output))
        .pipe(dest(rep_output));
}


function compilation_style(tab_fichier_input, rep_output, fichier_output) {
    src(tab_fichier_input)
        .pipe(cleanCSS({compatibility: 'ie8', rebase: false}))
        .pipe(concat(fichier_output))
        .pipe(dest(rep_output));
}


function bootstrap(cb) {
    compilation_sass(fichiers.bootstrap, config.dir + 'css', 'bootstrap.css');
    cb();
}

function bootstrap2spip(cb) {
    compilation_sass2spip(fichiers.bootstrap2spip, config.dir + 'css', 'bootstrap2spip.css');
    cb();
}


function sass(cb) {
    compilation_sass(fichiers.sass, config.dir + 'css', 'styles_sass.css');
    cb();
}


function styles(cb) {
    compilation_style(fichiers.styles, config.publicDir + 'css', 'perso.css')
    cb();
}


/////////////////////////////////////////////////////
// fonctions FEUILLES DE STYLES LESS
////////////////////////////////////////////////////


function compilation_less(tab_fichier_input, rep_output, fichier_output) {
    src(tab_fichier_input)
        .pipe(less({
            paths: [config.dir + '/less', config.bootstrapDir + '/less', config.dir + '/less/bootstrap2spip']
        }))
        .pipe(cleanCSS({compatibility: 'ie8', rebase: false}))
        .pipe(concat(fichier_output))
        .pipe(dest(rep_output));
}


/////////////////////////////////////////////////////
// fonctions SCRIPTS JS
////////////////////////////////////////////////////


// Lint Task
function lint(cb) {
    src(config.dir + 'js/*.js')
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
    cb();
}


function compilation_scripts(tab_fichier_input, rep_output, fichier_output) {
    flux = src(tab_fichier_input)
        .pipe(concat(fichier_output));
    if (!config.debug){
        flux = flux.pipe(uglify())
    }
    flux.pipe(dest(rep_output));
}


function scripts(cb) {
    compilation_scripts(fichiers.scripts, config.publicDir + 'js', 'scripts.js');
    cb();
}

function scripts_bas_de_page(cb) {
    compilation_scripts(fichiers.scripts_bas_de_page, config.publicDir + 'js', 'scripts_footer.js');
    cb();
}


/////////////////////////////////////////////////////
// fonctions icones et typo
////////////////////////////////////////////////////

function googlefonts(cb) {
    src(config.dir + 'fonts.list')
        .pipe(googleWebFonts({
            fontsDir: '../fonts',
            cssDir: '../css'
        }).on('error', logError))
        .pipe(dest(config.dir + 'fonts/').on('error', logError));
    cb();
}

function copie_fonts(cb) {
    src([
        config.dir + 'fonts/*.{ttf,woff,woff2,eof,svg}'
    ])
        .pipe(dest(config.publicDir + 'fonts'));
    cb();
}


function fontawesome(cb) {
    src(config.nodeDir + '@fortawesome/fontawesome-free/js/all.js')
        .pipe(rename('all.fa-min.js'))
        .pipe(faMinify(icones_fa))
        .pipe(uglify())
        .pipe(dest(config.dir + 'js'));
    cb();
}


function flag_sass(cb) {
    src([
        config.dir + 'sass/flag-icon.sass'
    ]).pipe(gulpsass({
        includePaths: [config.dir + 'scss', config.nodeDir + 'flag-icon-css/sass']
    }))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(concat('flag.css'))
        .pipe(dest(config.publicDir + 'css'));
    cb();
}


function flag_copie(cb) {
    src([
        config.nodeDir + 'flag-icon-css/flags/**/*.svg'
    ]).pipe(dest(config.publicDir + 'flags'));
    cb();
}


/////////////////////////////////////////////////////
// fonctions template
////////////////////////////////////////////////////

function templates(cb) {
    src(config.dir + 'templates/**/*.html')
        .pipe(gulptemplate({namespace: 'templates'}))
        .pipe(concat('templates.js'))
        .pipe(dest(config.dir + 'js/'));
    cb();
}


/////////////////////////////////////////////////////
// fonctions icon
////////////////////////////////////////////////////


function iconfont(cb) {

    var iconStream = src([config.dir + '/font-svg/*.svg'])
        .pipe(gulpiconfont({
            fontName: 'iconfont',
            prependUnicode: true,
            timestamp: runTimestamp,
            normalize: true,
            formats: ['ttf', 'eot', 'woff', 'woff2', 'svg']
        }));

    parallel([
        function handleGlyphs(cb) {
            iconStream.on('glyphs', function (glyphs, options) {
                src(config.dir + '/font-svg/template-font.css')
                    .pipe(consolidate('lodash', {
                        glyphs: glyphs,
                        fontName: 'iconfont',
                        fontPath: '../fonts/',
                        className: 'ico',

                    }))
                    .pipe(rename("iconfont.css"))
                    .pipe(dest(config.dir + '/font-svg'))
                    .on('finish', cb);
            });
        },
        function handleFonts(cb) {
            iconStream
                .pipe(dest(config.publicDir + '/fonts'))
                .on('finish', cb);
        }
    ], done);

    cb();
}

function sprite(cb) {

    src(config.dir + 'sprite/*.png')
        .pipe(spritesmith({
            imgName: 'sprite.png',
            cssName: 'sprite.scss'
        }))
        .pipe(buffer())
        //.pipe(spritesmash())
        .pipe(dest(config.dir + 'sprite/dist'));
    cb();
}

function icons(cb) {
    src([
        config.nodeDir + 'datatables/media/images/*.png',
    ]).pipe(dest(config.publicDir + '/css/images'));
    cb();
}



/////////////////////////////////////////////////////
// fonctions specifiques
////////////////////////////////////////////////////




function styles_carto(cb) {
    compilation_style(fichiers.styles_carto,config.publicDir + 'css','carto.css')
    cb();
}
function scripts_carto(cb) {
    compilation_scripts(fichiers.scripts_carto,config.publicDir + 'js','carto.js')
    cb();
}

function icons_carto(cb){
    src([ config.nodeDir + 'leaflet-draw/dist/images/*',])
        .pipe(dest(config.publicDir + '/css/images'));
    src([ config.nodeDir + 'leaflet-fullscreen/dist/*.png'])
        .pipe(dest(config.publicDir + '/css'));
    cb();
}


function fichier_carto(cb){
    src([ config.nodeDir + 'leaflet/dist/images/*.png'])
        .pipe(gulp.dest(config.publicDir + 'css/images'));
    cb();
}


exports.styles_carto = styles_carto;
exports.scripts_carto = scripts_carto;
exports.icons_carto = icons_carto;
exports.fichier_carto = fichier_carto;




function styles_jodit(cb) {
    compilation_style(fichiers.styles_jodit,config.publicDir + 'css','wysi.css')
    cb();
}
function scripts_jodit(cb) {
    compilation_scripts(fichiers.scripts_jodit,config.publicDir + 'js','wysi.js')
    cb();
}

exports.styles_jodit = styles_jodit;
exports.scripts_jodit = scripts_jodit;




function styles_querybuilder(cb) {
    compilation_style(fichiers.styles_querybuilder,config.publicDir + 'css','querybuilder.css')
    cb();
}

function scripts_querybuilder(cb) {
    compilation_scripts(fichiers.scripts_querybuilder,config.publicDir + 'js','querybuilder.js')
    cb();
}

exports.styles_querybuilder = styles_querybuilder;
exports.scripts_querybuilder = scripts_querybuilder;



function scripts_stat(cb) {
    compilation_scripts(fichiers.scripts_stat,config.publicDir + 'js','stat.js')
    cb();
}

exports.scripts_stat = scripts_stat;


