<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <div class="slug-side-menu">
            <post-sidebar :parent-page="'/lisateenused'" :menu-id="13" />
          </div>
        </div>
        <div v-if="contentIsLoaded" class="col-md-9 col-sm-12">
          <div class="heading-container">
            <h1 class="post-title">
              {{ content.title.rendered }}
            </h1>
          </div>
          <content-renderer :type="'post'" :slug="this.$route.path.replace('/lisateenused/', '')" />
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
  head: function() {
    return {
      title: 'Vana mööbli transport ja utiliseerimine | OK Movers',
      meta: [
        {
          hid: 'description',
          name: 'description',
          content:
            'Utiliseerime ja transpordime vana mööblit ning teostame kodumasinate äravedu. Utiliseerime vastavalt soovile kas ühe eseme või terve korteri mööbli kaupa.'
        }
      ],
      link: [
        {
          rel: 'canonical',
          href:
            'https://www.okmovers.ee/lisateenused/vana-moobli-transport-ja-utiliseerimine'
        }
      ]
    }
  },
  mounted: function() {
    this.getData()
  },
  methods: {
    getData: function() {
      const self = this
      this.$axios
        .get('posts?slug=' + this.$route.path.replace('/lisateenused/', ''))
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
