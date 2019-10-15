/* eslint-disable no-dupe-keys */
const pkg = require('./package')

module.exports = {
  mode: 'universal',

  /*
  ** Headers of the page
  */
  head: {
    title: pkg.name,
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: pkg.description }
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
    link: [
      {
        rel: 'stylesheet',
        type: 'font',
        href: '"https://fonts.googleapis.com/css?family=Montserrat:400,500,600"'
      }
    ]
  },
  /*
  ** Customize the progress-bar color
  */
  loading: { color: 'transparent' },
  transition: 'page',
  /*
  ** Global CSS
  */
  css: [],
  generate: {
    routes: [
      '/kolimisnouanded/millest-alustada-kui-ees-ootab-kolimine',
      '/kolimisnouanded/plaanis-tellida-kolimisteenus-kui-pikalt-pean-ette-teatama',
      '/kolimisnouanded/lillede-kolimine-kulma-ilmaga-kuidas-seda-teha',
      '/kolimisnouanded/ladustamine-milline-on-hea-ladustamiskeskkond',
      '/kolimisnouanded/kuidas-pakkida-nippe-proffidelt',
      '/kolimisnouanded/miks-tellida',
      '/kolimisnouanded/kolimisteenused-kolimisfirmalt-tellides-saad-garantii',
      '/kolimisnouanded/transport-vs-kolimine-mis-on-erinevus',
      '/kolimisnouanded/kuidas-kasutada-teiparit',
      '/kolimisnouanded/kuidas-kolimiskasti-kokku-teipida',
      '/kolimisnouanded/5-asja-mida-panna-tahele-kui-ees-on-kolimine',
      '/kolimisnouanded/noude-ja-klaaside-pakkimine',
      '/kolimisnouanded/kuidas-kujuneb-kolimise-hind',
      '/kolimisnouanded/kolimine-helsingisse'
    ]
  },
  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    { src: '@/plugins/velocity.js', ssr: false },
    { src: '@/plugins/vuelidate.js', ssr: false }
  ],

  /*
  ** Nuxt.js modules
  */
  modules: [
    // Doc: https://axios.nuxtjs.org/usage
    '@nuxtjs/axios',
    // Doc: https://bootstrap-vue.js.org/docs/
    'bootstrap-vue/nuxt',
    '@nuxtjs/sitemap',
    '@nuxtjs/google-analytics'
  ],
  googleAnalytics: {
    id: 'UA-97565526-3'
  },
  /*
  ** Axios module configuration
  */
  axios: {
    // See https://github.com/nuxt-community/axios-module#options
    baseURL: 'https://cms.okmovers.ee/wp-json/wp/v2/'
  },

  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
      // Run ESLint on save
      if (ctx.isDev && ctx.isClient) {
        config.module.rules.push({
          enforce: 'pre',
          test: /\.(js|vue)$/,
          loader: 'eslint-loader',
          exclude: /(node_modules)/
        })
      }
    }
  }
}
