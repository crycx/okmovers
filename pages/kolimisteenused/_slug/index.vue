<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-3">
          <div class="slug-side-menu">
            <post-sidebar :menu-id="10" :parent-page="'/kolimisteenused'" />
          </div>
        </div>
        <div v-if="contentIsLoaded" class="col-9">
          <div class="heading-container">
            <h1 class="post-title">
              {{ content.title.rendered }}
            </h1>
          </div>
          <content-renderer :type="'post'" :slug="this.$route.path.replace('/kolimisteenused/', '')" />
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
  data: function() {
    return {
      content: null,
      contentIsLoaded: false
    }
  },
  mounted: function() {
    this.getData()
  },
  methods: {
    getData: function() {
      const self = this
      this.$axios
        .get('posts?slug=' + this.$route.path.replace('/kolimisteenused/', ''))
        .then(function(response) {
          console.log(response)
          self.content = response.data[0]
          self.contentIsLoaded = true
        })
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
