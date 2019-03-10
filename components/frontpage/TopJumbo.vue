<template>
  <b-jumbotron class="top-jumbo">
    <div class="col-10 offset-1">
      <div class="row frontpage-header">
        <h2>Mida me pakume</h2>
      </div>
      <div class="row">
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
      </div>
      <div class="row">
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
        <front-page-icon :title="'Eraisikute Kolimine'" :text="'sakdoasmolkdasokld'" />
      </div>
    </div>
  </b-jumbotron>
</template>

<script>
import FrontPageIcon from '@/components/general/FrontPageIcon.vue'
export default {
  components: {
    FrontPageIcon
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';

.top-jumbo {
  background-color: $blue;
  color: white;
  padding-top: 1%;
}
.frontpage-header {
  display: flex;
  justify-content: center;
  text-align: center;
  color: $orange;
}
</style>
