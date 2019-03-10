<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-3">
          <div class="slug-side-menu">
            <ul class="slug-side-menu-ul">
              <li class="slug-side-menu-item">
                asd
              </li>
              <li>asd</li>
              <li>asd</li>
              <li>asd</li>
            </ul>
          </div>
        </div>
        <div class="col-9">
          <h2>asd</h2>
          <p>akjsndkijnasd</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.slug-side-menu {
  background-color: $blue;
  color: white;
  margin-top: 75px;
  .slug-side-menu-ul {
    list-style-type: none;

    .slug-side-menu-item {
      font-size: 20px;
    }
    .slug-side-menu-item:hover {
      color: $orange;
    }
  }
}
</style>
