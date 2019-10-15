<template>
  <div class="col-md-12 col-lg-2 client-image-col">
    <img :src="url" class="client-image">
  </div>
</template>

<script>
export default {
  props: {
    url: {
      type: String,
      default: 'https://via.placeholder.com/150'
    }
  }
}
</script>

<style lang="scss">
.client-image-col {
  display: flex;
  justify-content: center;
  .client-image {
    height: 200px;
    width: 200px;
  }
}
</style>
