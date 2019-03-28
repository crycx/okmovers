<template>
  <ul v-if="dataIsLoaded" class="slug-side-menu-ul">
    <li v-for="item in content" :key="item.id" class="slug-side-menu-item">
      <nuxt-link :to="$route.path + '/' + item.object_slug">
        {{ item.title }}
      </nuxt-link>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    menuId: {
      type: Number,
      default: null
    }
  },
  data: function() {
    return {
      content: [],
      dataIsLoaded: false
    }
  },
  mounted: function() {
    this.getSidebarItems()
    console.log(this.$route.path)
  },
  methods: {
    getSidebarItems: function() {
      const self = this

      this.$axios
        .get(
          'http://playground.ermine.ee/okmovers-api/wp-json/wp-api-menus/v2/menus/' +
            this.menuId
        )
        .then(function(response) {
          console.log(response)
          self.content = response.data.items
          console.log(self.content)
          self.dataIsLoaded = true
        })
    }
  }
}
</script>

<style>
</style>
