<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <div class="slug-side-menu">
            <post-sidebar :menu-id="10" :parent-page="'/kolimisteenused'" />
          </div>
        </div>
        <div v-if="contentIsLoaded" class="col-md-9 col-sm-12">
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
import Utils from '@/assets/utils.js'
export default {
  components: {
    ContentRenderer,
    PostSidebar
  },
  data: function() {
    return {
      content: null,
      contentIsLoaded: false,
      seoData: null
    }
  },
  head: function() {
    return {
      title: ' Ettevõtete kolimisteenused | OK Movers',
      meta: [
        {
          hid: 'description',
          name: 'description',
          content:
            'Kolime Teie kontori, lao või kauba sihtkohta kiirelt, mugavalt ja turvaliselt. Kui otsid partnerit kolimiseks, siis vali oma ala spetsialistid.'
        }
      ]
    }
  },
  created: function() {
    this.getSeo()
  },
  mounted: function() {
    this.getData()
  },
  methods: {
    getSeo: function() {
      const slug = this.$route.path.replace('/kolimisteenused/', '')
      this.seoData = Utils.getSeoData(slug)
    },
    getData: function() {
      const self = this
      this.$axios
        .get('posts?slug=' + this.$route.path.replace('/kolimisteenused/', ''))
        .then(function(response) {
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
