<template>
  <div class="content page-index">
    <top-jumbo />
    <clients />
  </div>
</template>

<script>
import Clients from '@/components/frontpage/Clients.vue'
import TopJumbo from '@/components/frontpage/TopJumbo.vue'
export default {
  components: {
    Clients,
    TopJumbo
  }
}
</script>

<style lang="scss">
@import '~/assets/globals.scss';

.content {
  height: unquote('calc(100vh - #{$navbar-height} - #{$footer-height})');
}
</style>
