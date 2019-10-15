<template>
  <div class="contact-header container">
    <div class="row">
      <div v-if="imageIsLoaded" class="col-lg-2 col-sm-12 offset-lg-2 contact-header-logo-col">
        <img class="contact-header-logo" :src="imageUrl">
      </div>
      <div v-if="contentIsLoaded" class="col-lg-6 col-sm-12 contact-header-text-col" v-html="content" />
    </div>
  </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      content: null,
      contentIsLoaded: false,
      imageId: null,
      imageUrl: null,
      imageIsLoaded: false
    }
  },
  watch: {
    contentIsLoaded: function() {
      const self = this
      if (this.contentIsLoaded === true) {
        this.$axios.get('media/' + this.imageId).then(function(response) {
          self.imageUrl = response.data.source_url
          self.imageIsLoaded = true
        })
      } else {
        this.imageIsLoaded = false
      }
    }
  },
  mounted: function() {
    this.getHeaderData()
  },
  methods: {
    getHeaderData: function() {
      const self = this
      this.$axios.get('posts/359').then(function(response) {
        self.content = response.data.content.rendered
        self.imageId = response.data.featured_media
        self.contentIsLoaded = true
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.contact-header {
  margin-top: 15px;
  margin-bottom: 15px;
}
.contact-header-logo {
  max-width: 100px;
  max-height: 100px;
}
.contact-header-logo-col {
  display: flex;
  justify-content: center;
  align-items: center;
}
.contact-header-text-col {
  display: flex;
  justify-content: center;
  align-items: center;
  p {
    justify-content: center;
    text-align: center;
    font-size: 16px;
    font-weight: 500;
  }
}
@media screen and (max-width: $lg) {
  .contact-header-text-col {
    margin-top: 15px;
    p {
      justify-content: center;
      text-align: center;
      font-size: 16px;
      font-weight: 500;
    }
  }
}
</style>
