<template>
  <div class="frontpage-icon col-sm-12 col-md">
    <nuxt-link :to="'/kolimisteenused/' + slug">
      <div v-if="imageIsRetrived" class="frontpage-icon-container">
        <img class="frontpage-icon-image" :src="imageSrc">
      </div>
      <div class="frontpage-icon-header-container">
        <h3 class="frontpage-icon-header">
          {{ title.toUpperCase() }}
        </h3>
      </div>
      <div class="frontpage-icon-text" v-html="text" />
    </nuxt-link>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: ''
    },
    text: {
      type: String,
      default: ''
    },
    featuredImage: {
      type: Number,
      default: null
    },
    slug: {
      type: String,
      default: ''
    }
  },
  data: function() {
    return {
      imageSrc: '',
      imageIsRetrived: false
    }
  },
  mounted: function() {
    this.getImage()
  },
  methods: {
    getImage: function() {
      const self = this
      this.$axios.get('media/' + this.featuredImage).then(function(response) {
        self.imageSrc = response.data.source_url
        self.imageIsRetrived = true
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.frontpage-icon {
  text-align: center;
  display: flex;
  align-content: flex-start;
  justify-content: flex-start;
  flex-direction: column;
  transition-property: color;
  transition-duration: 0.25s;
  transition-timing-function: linear;
  a {
    color: white;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    flex-direction: column;
    .frontpage-icon-container {
      border-radius: 6px;
      display: flex;
      justify-content: center;
      flex-direction: column;
      background-color: $orange;
      align-items: center;
      height: 120px;
      width: 120px;
      transition-property: background;
      transition-duration: 0.25s;
      transition-timing-function: linear;
      margin-bottom: 10px;
      .frontpage-icon-image {
        height: 100px;
        width: 100px;
      }
      &:hover {
        background-color: $blue;
      }
    }
    .frontpage-icon-header {
      font-size: 20px;
    }
    .frontpage-icon-text {
      p {
        font-size: 14px;
      }
      &:hover {
        color: $orange;
      }
    }
  }
}
.frontpage-icon:hover {
  color: $orange;
  a {
    .frontpage-icon-header {
      color: $orange;
    }
    .frontpage-icon-text {
      color: $orange;
    }
  }
}
</style>
