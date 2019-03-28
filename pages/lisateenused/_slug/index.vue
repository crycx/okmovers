<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-3">
          <div class="slug-side-menu">
            <page-sidebar />
          </div>
        </div>
        <div class="col-9">
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
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.slug-side-menu {
  background-color: $blue;
  color: white;
  margin-top: 75px;
  .slug-side-menu-ul {
    list-style-type: none;

    .slug-side-menu-item {
      font-size: 20px;
    }
    .slug-side-menu-item:hover {
      color: $orange;
    }
  }
}
.heading-container {
  text-align: center;
  .post-title {
    color: $orange;
  }
}
</style>
