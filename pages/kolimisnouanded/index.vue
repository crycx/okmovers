<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-3">
          <div class="slug-side-menu">
            <page-sidebar :menu-id="11" />
          </div>
        </div>
        <div class="col-9">
          <div class="heading-container">
            <h1 class="post-title">
              Kolimisnõuanded
            </h1>
          </div>
          <content-renderer :id="28" :type="'page'" />
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
  mounted: function() {}
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
