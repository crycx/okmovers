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
    type: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      content: 'asd',
      contentIsRendered: false
    }
  },
  mounted: function() {
    console.log(this.type)
    this.retrievePageData()
  },
  methods: {
    retrievePageData: function() {
      const self = this
      if (this.type === 'post') {
        this.$axios.get('posts/' + this.id).then(function(response) {
          self.content = response.data.content.rendered
          self.contentIsRendered = true
        })
      } else if (this.type === 'page') {
        this.$axios.get('pages/' + this.id).then(function(response) {
          self.content = response.data.content.rendered
          self.contentIsRendered = true
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
