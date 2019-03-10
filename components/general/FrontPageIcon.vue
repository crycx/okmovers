<template>
  <b-col class="frontpage-icon col-sm">
    <img class="frontpage-icon-image" src="https://via.placeholder.com/100">
    <h3 class="frontpage-icon-header">
      {{ title }}
    </h3>
    <p class="frontpage-icon-text">
      {{ text }}
    </p>
  </b-col>
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
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.frontpage-icon {
  text-align: center;
  .frontpage-icon-header {
    font-size: 24px;
  }
  .frontpage-icon-text {
    font-size: 14px;
  }
}
.frontpage-icon:hover {
  color: $orange;
}
</style>
