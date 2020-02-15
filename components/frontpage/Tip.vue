<template>
  <div v-if="imageIsLoaded" class="col-md-2 col-sm-6 tip-col">
    <nuxt-link
      :to="'/kolimisnouanded/' + slug"
    >
      <div
        class="tip-container"
      >
        <img :src="imgUrl" class="tip-logo">
      </div>
    
      <div class="text-container">
        <p>{{ title }}</p>
      </div>
    </nuxt-link>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: 'text'
    },
    slug: {
      type: String,
      default: ''
    },
    imgUrl: {
      type: Number,
      default: null
    }
  },
  data() {
    return {
      imageIsLoaded: false
    }
  },
  mounted() {
    this.loadImage()
  },
  methods: {
    loadImage() {
      const self = this
      this.$axios.get('media/' + this.imgUrl).then(function(response) {
        self.imgUrl = response.data.guid.rendered
        console.log(self.imgUrl)
        self.imageIsLoaded = true
      })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.tip-col {
  flex: 0 0 14.25%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-items: center;
  a {
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-items: center;
    .tip-container {
      width: 125px;
      height: 125px;
      background-color: $orange;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition-property: background;
      transition-duration: 0.125s;
      transition-timing-function: linear;
      .tip-logo {
        height: 90px;
        width: 90px;
      }
    }
    .text-container {
      color: $blue;
      font-size: 18px;
      font-weight: bold;
      text-align: center;
      margin-top: 10px;
      transition-property: color;
      transition-duration: 0.125s;
      transition-timing-function: linear;
      -ms-hyphens: auto;
      -moz-hyphens: auto;
      -webkit-hyphens: auto;
      hyphens: auto;
      p {
        -ms-hyphens: auto;
        -moz-hyphens: auto;
        -webkit-hyphens: auto;
        hyphens: auto;
      }
    }
  }

  &:hover {
    a {
      .tip-container {
        background-color: $blue;
      }
      .text-container {
        color: $orange;
      }
    }
  }

  @media screen and (max-width: $md) {
    .tip-col {
      flex: 0 0 33%;
    }
  }
  @media screen and (max-width: $lg) {
    .text-container {
      p {
        font-size: 14px;
      }
    }
  }
}
</style>
