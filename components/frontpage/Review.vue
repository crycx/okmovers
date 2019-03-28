<template>
  <div class="col-6 review">
    <div class="row">
      <div class="col-4 review-left">
        <img src="https://via.placeholder.com/150" class="client-image">
        <p class="client-name">
          {{ title }}
        </p>
      </div>
      <div class="col-8 review-right">
        <div class="review-speechbubble" v-html="content"/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      default: ''
    },
    content: {
      type: String,
      default: ''
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.review-left {
  display: flex;
  text-align: center;
  flex-direction: column;
  justify-items: center;
  align-items: center;
  .client-name {
    color: $orange;
    font-weight: bold;
    font-size: 20px;
  }
  .client-image {
    max-width: 150px;
    max-height: 150px;
    border-radius: 50%;
  }
}
.review-right {
  display: flex;
  justify-content: center;
  .review-speechbubble {
    position: relative;
    height: 80%;
    width: 80%;
    background-color: $blue;
    color: white;
    text-align: center;
    &:after {
      position: absolute;
      content: '';
      left: 0;
      top: 50%;
      border: 30px solid transparent;
      border-right-color: $blue;
      border-left: 0;
      margin-top: -30px;
      margin-left: -30px;
    }
  }
}
</style>
