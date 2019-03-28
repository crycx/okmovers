<template>
  <div class="navbar-wrapper">
    <div class="row">
      <b-navbar id="navbar" class="navbar" type="dark">
        <b-navbar-brand>
          <nuxt-link to="/">
            <img
              src="http://via.placeholder.com/50"
            >
          </nuxt-link>
        </b-navbar-brand>
        <b-navbar-nav class="nav-menu">
          <nuxt-link v-for="item in menuItems" :key="item.id" :to="{ path: '/' + item.object_slug }">
            {{ item.title }}  
          </nuxt-link>
        </b-navbar-nav>
        <div class="info-container ml-auto">
          <div class="row">
            telnr
          </div>
          <div class="row">
            email
          </div>
        </div>
      </b-navbar>
    </div>
    <div class="fake-margin" />
  </div>
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
.navbar-wrapper {
  .row {
    margin-left: 0;
    margin-right: 0;
  }
}
.navbar {
  background-color: $blue;
  color: white;
  height: $navbar-height;
  width: 100%;
}
.nav-menu {
  display: flex;
  list-style-type: none;
  height: 100%;
  width: 100%;
  align-items: center;
  justify-content: space-evenly;
  a {
  }
  a {
    position: relative;
    color: white;
    text-decoration-line: none;
    background-color: rgba(246, 162, 30, 0);
    width: 100%;
    text-align: center;
    &:after {
      content: '';
      background-color: $orange;
      bottom: -18px;
      height: 5px;
      left: 0;
      position: absolute;
      width: 0;
    }
    &:hover {
      color: $orange;
      &:after {
        width: 100%;
      }
    }
  }
}
.nav-link {
  a {
    &:after {
      content: '';
      background-color: $orange;
      bottom: -10px;
      height: 5px;
      left: 0;
      position: absolute;
      width: 0;
      visibility: hidden;
    }
  }
}
.nav-menu-item {
  background-color: rgba(246, 162, 30, 0);
  width: 100%;
  text-align: center;
}
.info-container {
  width: 5%;
}
.fake-margin {
  min-width: 100%;
  min-height: 5px;
}
</style>
