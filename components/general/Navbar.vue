<template>
  <b-navbar id="navbar" class="navbar" type="dark">
    <b-navbar-brand>
      <a />
    </b-navbar-brand>
    <b-navbar-nav class="nav-menu">
      <b-nav-item v-for="item in menuItems" :key="item.id" class="nav-menu-item" :href="item.url">
        {{ item.title }}
      </b-nav-item>
    </b-navbar-nav>
  </b-navbar>
</template>

<script>
export default {
  data: function() {
    return {
      menuItems: []
    }
  },
  mounted: function() {
    this.getNavMenu()
  },
  methods: {
    getNavMenu: function() {
      const self = this
      this.$axios
        .get(
          'http://playground.ermine.ee/okmovers-api/wp-json/wp-api-menus/v2/menus/2'
        )
        .then(function(response) {
          self.menuItems = response.data.items
          console.log(self.menuItems)
        })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';

.navbar {
  background-color: $blue;
  color: white;
  height: $navbar-height;
  margin-bottom: 5px;
}
.nav-menu {
  display: flex;
  list-style-type: none;
  height: 100%;
  align-items: center;
  justify-content: space-evenly;
  .nav-menu-item {
    background-color: rgba(246, 162, 30, 0);
    width: 100%;
    text-align: center;
    a {
      color: white;
      text-decoration-line: none;
      background-color: rgba(246, 162, 30, 0);
      &:hover {
        color: $orange;
        &:after {
          width: 100%;
        }
      }
      &:after {
        content: '';
        background-color: $orange;
        left: inherit;
        top: $navbar-height;
        height: 5px;
        position: absolute;
        width: 0;
      }
    }
  }
}
</style>
