<template>
  <div class="navbar-wrapper">
    <div class="row">
      <b-navbar id="navbar" toggleable="lg" class="navbar" type="dark">
        <b-navbar-brand>
          <nuxt-link to="/">
            <img
              class="navbar-logo"
              src="@/assets/okm.png"
            >
          </nuxt-link>
        </b-navbar-brand>
        <div class="phone-mobile d-md-block d-lg-none">
          <div class="row phone-mobile-row">
            <img class="phone-mobile-logo" src="@/assets/phone.png">
            <a class="phone-mobile-text" href="tel:5047187">
              5047187
            </a>
          </div>
        </div>
        <b-navbar-toggle target="nav-collapse" />
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="nav-menu">
            <nuxt-link v-for="item in menuItems" :key="item.id" :to="{ path: '/' + item.object_slug }" :class="item.object_slug">
              {{ item.title }}  
            </nuxt-link>
          </b-navbar-nav>
          <div class="info-container">
            <div class="row d-none d-lg-flex">
              <img class="phone-mobile-logo-small" src="@/assets/phone.png">
              <a class="phone-text-small" href="tel:5047187">
                5047187
              </a>
            </div>
            <div class="row mail-row">
              <img class="mail-logo-small" src="@/assets/mail.png">
              <a class="mail-text" href="mailto:info@okmovers.ee">
                INFO@OKMOVERS.EE
              </a>
            </div>
          </div>
        </b-collapse>
      </b-navbar>
      <div class="fake-margin" />
    </div>
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
        .get('https://cms.okmovers.ee/wp-json/wp-api-menus/v2/menus/2')
        .then(function(response) {
          self.menuItems = response.data.items
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
  font-weight: 600;
  z-index: 9999;
}
.navbar-logo {
  height: 50px;
  width: 50px;
}
@media screen and (max-width: $lg) {
  .navbar {
    height: 70px;
    padding: 0;
  }
  .navbar-brand {
    padding: 0;
  }
  .navbar-toggler {
    margin-right: 15px;
  }
  .navbar-logo {
    height: 70px;
    width: 70px;
  }
  .info-container {
    padding-bottom: 20px;
    border-bottom: 2px solid $orange;
  }
}
.navbar-brand {
  margin-right: 0;
}
.phone-mobile-logo {
  height: 30px;
  width: 30px;
  margin-right: 3px;
}
.phone-mobile-logo-small {
  display: flex;
  align-self: center;
  height: 20px;
  width: 20px;
  margin-right: 3px;
}
.mail-logo-small {
  display: flex;
  align-self: center;
  height: 20px;
  width: 20px;
  margin-right: 3px;
}
.mail-text {
  display: flex;
  align-self: center;
  font-size: 14px;
}
.phone-text-small {
  display: flex;
  align-self: center;
  font-size: 14px;
}
.nav-menu {
  display: flex;
  list-style-type: none;
  height: 100%;
  width: 87%;
  align-items: center;
  justify-content: space-evenly;
  .hinnaparing {
    color: $green;
  }
  a {
    position: relative;
    color: white;
    text-decoration-line: none;
    background-color: rgba(246, 162, 30, 0);
    width: 100%;
    text-align: center;
    transition-property: color;
    transition-duration: 0.25s;
    transition-timing-function: linear;
    &:after {
      content: '';
      background-color: $orange;
      bottom: -18px;
      height: 5px;
      left: 0;
      position: absolute;
      width: 0;
      transition-property: width;
      transition-duration: 0.05s;
      transition-timing-function: linear;
    }
    &:hover {
      color: $orange;
      &:after {
        width: 100%;
      }
    }
  }
  .nuxt-link-active {
    color: $orange;
    &:after {
      width: 100%;
    }
  }
}
.info-container {
  width: 11%;
  a {
    color: $orange;
    font-weight: 500;
    &:hover {
      color: $orange-dark;
      text-decoration: none;
    }
  }
}
@media screen and (max-width: 1666px) {
  .info-container {
    a {
      font-size: 10px;
    }
  }
}
@media screen and (max-width: 1470px) {
  .navbar-nav {
    a {
      font-size: 14px;
    }
  }
}
@media screen and (max-width: 1308px) {
  .navbar-nav {
    a {
      font-size: 12px;
    }
  }
}
@media screen and (max-width: 1272px) {
  .info-container {
    a {
      font-size: 9px;
    }
  }
}
@media screen and (max-width: 1150px) {
  .navbar-nav {
    a {
      font-size: 10px;
    }
  }
}
@media screen and (max-width: $lg) {
  .info-container {
    background-color: $blue;
    width: 100%;
    text-align: center;
    .row {
      display: flex;
      justify-content: center;
    }
    a {
      color: $orange;
      font-weight: 600;
      font-size: 12px;
      &:hover {
        color: $orange-dark;
        text-decoration: none;
      }
    }
  }
  .phone-mobile-row {
    a {
      color: $orange;
      display: flex;
      align-self: center;
    }
  }
  .nav-menu {
    background-color: $blue;
    width: 100%;
    margin: 0;
    z-index: 9999;
    a {
      margin-top: 5px;
      margin-bottom: 5px;
      font-size: 12px;
      &:after {
        content: '';
        background-color: transparent;
        bottom: -18px;
        height: 5px;
        left: 0;
        position: absolute;
        width: 0;
        transition-property: width;
        transition-duration: 0.05s;
        transition-timing-function: linear;
      }
      &:hover {
        color: $orange;
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

.fake-margin {
  min-width: 100%;
  min-height: 5px;
}
</style>
