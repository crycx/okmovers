<template>
  <div>
    <navbar />
    <cookie-law />
    <nuxt />
    <page-footer />
  </div>
</template>
<script>
import Navbar from '@/components/general/Navbar.vue'
import PageFooter from '@/components/general/PageFooter.vue'
import CookieLaw from '@/components/general/CookieLaw.vue'

export default {
  components: {
    Navbar,
    PageFooter,
    CookieLaw
  }
}
</script>
<style lang="scss">
@import '@/assets/globals.scss';
html {
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
  word-spacing: 1px;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
  -moz-osx-font-smoothing: grayscale;
  -webkit-font-smoothing: antialiased;
  box-sizing: border-box;
  max-width: 100%;
  width: 100%;
  overflow-x: hidden;
}
body {
  font-family: 'Montserrat', sans-serif;
  overflow-x: hidden;
}
button:focus {
  outline: none;
}
h1 {
  overflow-wrap: break-word;
}
@media screen and (max-width: $lg) {
  h1 {
    overflow-wrap: break-word;
    font-size: 26px;
  }
}
.jumbotron {
  border-radius: 0;
}
*,
*:before,
*:after {
  box-sizing: border-box;
  margin: 0;
}
</style>
