<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 col-md-10 offset-md-1">
          <div class="heading-container">
            <h1 class="post-title">
              Ladustamisteenused
            </h1>
          </div>
          <content-renderer :id="30" :type="'page'" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ContentRenderer from '@/components/general/ContentRenderer.vue'
export default {
  components: {
    ContentRenderer
  },
  mounted: function() {},
  head: function() {
    return {
      title: 'Ladustamine | OK Movers - Kolimine, Transport, Ladustamine',
      meta: [
        {
          hid: 'description',
          name: 'description',
          content:
            'Ladustamisteenused ja vara ladustamine lihtsalt ja soodsalt. Meie ladu on soe, turvatud ning kaup on soovitud ajal alati kättesaadav.'
        }
      ]
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.heading-container {
  text-align: center;
  .post-title {
    color: $orange;
  }
}
</style>
