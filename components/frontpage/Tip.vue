<template>
  <div class="col-2 tip-col">
    <nuxt-link
      :to="'/kolimisnouanded/' + slug"
    >
      <div
        class="tip-container"
      >
        <img src="~/assets/delivery-package.png" class="tip-logo">
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
}
</style>
