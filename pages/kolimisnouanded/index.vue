<template>
  <div class="content page-slug">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3 col-sm-12">
          <div class="slug-side-menu">
            <page-sidebar :menu-id="11" />
          </div>
        </div>
        <div class="col-md-9 col-sm-12">
          <div class="heading-container">
            <h1 class="post-title">
              Kolimisnõuanded
            </h1>
          </div>
          <content-renderer :id="28" :type="'page'" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PageSidebar from '@/components/general/PageSidebar.vue'
import ContentRenderer from '@/components/general/ContentRenderer.vue'
export default {
  components: {
    ContentRenderer,
    PageSidebar
  },
  mounted: function() {},
  head: function() {
    return {
      title: 'Kolimisnõuanded | OK Movers - Kolimine, Transport, Ladustamine',
      meta: [
        {
          hid: 'description',
          name: 'description',
          content:
            'Meie OK Moversis soovime, et sinu kolimine läheks nii sujuvalt kui võimalik ning selle käigus ei tabaks sind ükski üllatus ega mure. Selleks olemegi koostanud mitmed kolimisnõuanded.'
        }
      ],
      link: [
        { rel: 'canonical', href: 'https://www.okmovers.ee/kolimisnouanded' }
      ]
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/globals.scss';
.heading-container {
  text-align: center;
  .post-title {
    color: $orange;
  }
}
.slug-side-menu {
  background-color: $blue;
  color: white;
  margin-top: 75px;
}
</style>
