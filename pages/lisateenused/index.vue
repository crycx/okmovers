<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <div class="slug-side-menu">
            <page-sidebar :menu-id="13" />
          </div>
        </div>
        <div class="col-sm-12 col-md-9">
          <div class="heading-container">
            <h1 class="post-title">
              Lisateenused
            </h1>
          </div>
          <content-renderer :id="32" :type="'page'" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageSidebar from '@/components/general/PageSidebar.vue'
import ContentRenderer from '@/components/general/ContentRenderer.vue'
export default {
  components: {
    ContentRenderer,
    PageSidebar
  },
  mounted: function() {},
  head: function() {
    return {
      title: 'OK Movers',
      meta: [{ hid: 'description', name: 'description', content: 'asso pls' }]
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
