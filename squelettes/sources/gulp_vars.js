

const config = {
    nodeDir: './node_modules/',
    bootstrapDir: './node_modules/bootstrap/',
    dir: './',
    publicDir: './../',
    debug:false
};


const fichiers = {
    'bootstrap': [
        config.dir + 'scss/bootstrap/scss/bootstrap.scss'
    ],
    'bootstrap2spip': [
        config.dir + 'scss/bootstrap2spip/css/boot.scss',
        config.dir + 'scss/bootstrap2spip/css/spip.list.scss',
        config.dir + 'scss/bootstrap2spip/css/spip.admin.scss',
        config.dir + 'scss/bootstrap2spip/css/spip.css'
    ],
    'sass': [

        config.dir + 'scss/animation.scss',
        config.dir + 'scss/perso.scss',
        config.dir + 'scss/sommaire.scss',
        config.dir + 'scss/lunr.scss',
        config.dir + 'scss/sidr.scss'
    ],
    'styles': [
        config.nodeDir + 'sidr/dist/stylesheets/jquery.sidr.light.css',
        config.dir + 'css/fonts.css',
        config.dir + 'css/bootstrap.css',
        config.dir + 'css/bootstrap2spip.css',
        config.dir + 'css/styles_sass.css'
    ],
    'scripts': [
        config.dir+'js/all.fa-min.js',
        config.nodeDir + 'sidr/dist/jquery.sidr.js',
        config.nodeDir+'ion-sound/js/ion.sound.js',
        config.nodeDir+'jquery-validation/dist/jquery.validate.js',
        config.dir+'js/perso.js'
    ],
    'scripts_bas_de_page': [
        config.bootstrapDir + 'dist/js/bootstrap.bundle.js',
        config.dir+'js/lunr/mustache.js',
        config.dir+'js/lunr/elasticlunr.min.js',
        config.dir+'js/lunr/lunr.stremmer.support.min.js',
        config.dir+'js/lunr/lunr.fr.min.js',
        config.dir+'js/lunr/lunr.js'
    ],

};


const icones_fa = {
    fal: [],
    far: [],
    fas: ['download','map-marker','search','eye','tags','tag','chevron-left','chevron-right','bug','redo','exclamation-triangle','calendar','newspaper','bars','print','sign-out-alt','user','file-alt','file-audio','file-image','file-video'],
    fab: ['mastodon','twitter','facebook']
};


module.exports = [config,fichiers,icones_fa];