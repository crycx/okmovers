<template>
  <b-jumbotron class="top-jumbo">
    <div class="row">
      <div class="col-6 top-jumbo-left">
        <h2>Miks valida meid?</h2>
        <p>asdasdasd</p>
        <div class="row">
          <div class="col-6">
            <button class="frontpage-button frontpage-button-green">
              Esita kiire hinnapäring
            </button>
          </div>
          <div class="col-6">
            <button class="frontpage-button frontpage-button-blue">
              Vaata meie kolimisnippe
            </button>
          </div>
        </div>
      </div>
      <div class="col-6 top-jumbo-right">
        <div class="player-container">
          <div class="player" />
        </div>
      </div>
    </div>
  </b-jumbotron>
</template>

<script>
export default {}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.frontpage-button {
  border-radius: 6px;
  border-width: 0px;
  padding: 3% 3%;
}
.frontpage-button-blue {
  background-color: $blue;
  color: white;
  &:hover {
    background-color: $orange;
  }
}
.frontpage-button-green {
  border-style: solid;
  background-color: lightgreen;
  color: white;
  &:hover {
    border-color: $orange;
    background-color: $orange;
  }
}
.top-jumbo-left {
  text-align: center;
}
.player-container {
  background-color: $blue;
  height: 360px;
  width: 640px;
}
</style>
