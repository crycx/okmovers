<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="heading-container">
            <h1 class="post-title">
              Kontakt
            </h1>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-4" />
        <div class="col-8">
          <div class="col-8 offset-2">
            <b-form>
              <div class="form-group">
                <label for="name">Nimi</label>
                <b-input type="text" />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <b-input type="email" />
              </div>
              <div class="form-group">
                <b-textarea placeholder="Kirjuta meile!" />
              </div>
            </b-form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
export default {
  mounted: function() {}
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.slug-side-menu {
  background-color: $blue;
  color: white;
  margin-top: 75px;
  .slug-side-menu-ul {
    list-style-type: none;
    padding-left: 20px;
    padding-right: 20px;
    .slug-side-menu-item {
      font-size: 20px;
    }
    .slug-side-menu-item:hover {
      color: $orange;
    }
  }
}
.heading-container {
  text-align: center;
  .post-title {
    color: $orange;
  }
}
</style>
