<template>
  <b-col class="frontpage-icon col-sm">
    <div class="frontpage-icon-container">
      <img class="frontpage-icon-image" src="~/assets/youtube-logo.png">
    </div>
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
  display: flex;
  align-items: center;
  justify-content: center;
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
    .frontpage-icon-image {
      height: 100px;
      width: 100px;
    }
    &:hover {
      background-color: $orange-dark;
    }
  }
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
