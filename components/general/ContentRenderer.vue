<template>
  <div v-if="contentIsRendered" class="content-container" v-html="content[0].content.rendered" />
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      default: null
    },
    slug: {
      type: String,
      default: null
    },
    type: {
      type: String,
      default: ''
    }
  },
  head() {
    return {
      title: this.yoastTitle,
      meta: [
        {
          hid: 'description',
          id: 'description',
          name: 'description',
          content: this.yoastDesc
        }
      ]
    }
  },
  data: function() {
    return {
      contentIsRendered: false,
      content: ''
    }
  },
  mounted: function() {
    this.retrievePageData()
  },
  methods: {
    retrievePageData: function() {
      const self = this
      if (this.type === 'post') {
        if (this.id !== null) {
          this.$axios.get('posts/' + this.id).then(function(response) {
            self.content = response.data
            self.yoastTitle = response.data._yoast_wpseo_title
            self.yoastDesc = response.data._yoast_wpseo_metadesc
            self.contentIsRendered = true
            console.log(self.content)
          })
        } else if (this.slug !== null) {
          this.$axios.get('posts?slug=' + this.slug).then(function(response) {
            self.content = response.data
            self.contentIsLoaded = true
            console.log(self.content)
          })
        }
      } else if (this.type === 'page') {
        this.$axios.get('pages/' + this.id).then(function(response) {
          self.content = response.data
          self.contentIsLoaded = true
          console.log(self.content)
        })
      }
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.content-container {
  color: $blue;
}
.wp-block-image {
  img {
    max-width: 100%;
  }
}
</style>
