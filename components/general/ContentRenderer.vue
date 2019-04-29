<template>
  <div v-if="contentIsRendered" class="content-container" v-html="content" />
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
            self.content = response.data.content.rendered
            self.yoastTitle = response.data._yoast_wpseo_title
            self.yoastDesc = response.data._yoast_wpseo_metadesc
            self.contentIsRendered = true
            console.log(self.content)
          })
        } else if (this.slug !== null) {
          this.$axios.get('posts?slug=' + this.slug).then(function(response) {
            self.content = response.data[0].content.rendered
            self.contentIsRendered = true
            console.log(self.content)
          })
        }
      } else if (this.type === 'page') {
        this.$axios.get('pages/' + this.id).then(function(response) {
          self.content = response.data.content.rendered
          self.contentIsRendered = true
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
  padding-left: 4%;
  padding-right: 4%;
  .row {
    align-content: center;
    align-items: center;
    margin-top: 15px;
    margin-bottom: 15px;
  }
}
.wp-block-image {
  display: flex;
  justify-content: center;
  justify-items: center;
  align-content: center;
  align-items: center;
  align-self: center;
  margin: 0;
  img {
    max-height: 150px;
    max-width: 150px;
  }
}
@media screen and (max-width: $md) {
  .wp-block-image {
    display: none;
  }
  .content-container {
    text-align: center;
    .row {
      align-content: center;
      align-items: center;
      margin-top: 15px;
      margin-bottom: 15px;
    }
  }
}
</style>
