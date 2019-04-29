<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-3">
          <div class="slug-side-menu">
            <post-sidebar :parent-page="'/ettevottest'" :menu-id="14" />
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
import PostSidebar from '@/components/general/PostSidebar.vue'
import ContentRenderer from '@/components/general/ContentRenderer.vue'
export default {
  components: {
    ContentRenderer,
    PostSidebar
  },
  head: function() {
    return {
      title: 'Kolimisteenused | OK Movers – Kolimine, Transport, Ladustamine'
    }
  },
  mounted: function() {
    this.getPostData()
  },
  methods: {
    getPostData: function() {
      console.log(this.$route.path)
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
