<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <div class="slug-side-menu">
            <page-sidebar />
          </div>
        </div>
        <div class="col-md-9 col-sm-12">
          <div class="heading-container">
            <h1 class="post-title">
              asd
            </h1>
          </div>
          <content-renderer />
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
  head: function() {
    return {
      title: 'Kolimisteenused | OK Movers – Kolimine, Transport, Ladustamine'
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
