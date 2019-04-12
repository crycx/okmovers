<template>
  <div>
    <navbar />
    <nuxt />
    <page-footer />
  </div>
</template>
<script>
import Navbar from '@/components/general/Navbar.vue'
import PageFooter from '@/components/general/PageFooter.vue'

export default {
  components: {
    Navbar,
    PageFooter
  }
}
</script>
<style>
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
}
body {
  font-family: 'Montserrat', sans-serif;
  overflow-x: hidden;
}
button:focus {
  outline: none;
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
