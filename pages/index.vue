<template>
  <div class="content page-index">
    <top-jumbo />
    <reviews />
    <mid-jumbo />
    <clients />
    <tips />
  </div>
</template>

<script>
import TopJumbo from '@/components/frontpage/TopJumbo.vue'
import Reviews from '@/components/frontpage/Reviews.vue'
import Clients from '@/components/frontpage/Clients.vue'
import MidJumbo from '@/components/frontpage/MidJumbo.vue'
import Tips from '@/components/frontpage/Tips.vue'

export default {
  components: {
    TopJumbo,
    Reviews,
    Clients,
    MidJumbo,
    Tips
  },
  head: function() {
    return {
      title: 'OK Movers',
      meta: [{ hid: 'description', name: 'description', content: 'asso pls' }]
    }
  }
}
</script>

<style lang="scss">
@import '~/assets/globals.scss';
</style>
