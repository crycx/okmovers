<template>
  <div class="col-6 review">
    <div class="row">
      <div class="col-4 review-left">
        <img :src="imageUrl" class="client-image">
        <p class="client-name">
          {{ title }}
        </p>
      </div>
      <div class="col-8 review-right">
        <div class="review-speechbubble" v-html="content" />
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
    },
    imageUrl: {
      type: String,
      default: 'https://via.placeholder.com/150'
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.review {
  padding: 0;
}
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
    height: 150px;
    width: 150px;
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
    padding-top: 5%;
    padding-bottom: 5%;
    padding-right: 20px;
    padding-left: 20px;
    height: auto;
    width: 80%;
    background-color: $blue;
    color: white;
    text-align: center;
    font-size: 15px;
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
