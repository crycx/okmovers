<template>
  <div class="col-2 tip-col">
    <div class="tip-container">
      <img src="~/assets/delivery-package.png" class="tip-logo">
    </div>
    <div class="text-container">
      <p>text</p>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.tip-col {
  flex: 0 0 14.25%;
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
  }
  &:hover {
    .tip-container {
      background-color: $blue;
    }
    .text-container {
      color: $orange;
    }
  }
}
</style>
