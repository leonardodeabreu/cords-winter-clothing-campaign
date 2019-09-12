<template lang="pug">
  .admin
    v-toolbar(app fixed dark)
      v-spacer
      img(src="/img/logo_campanha.png" height="100")
      v-spacer
      template(v-slot:extension)
        v-tabs(
          grow
          dark
          color="grey darken-4"
          slider-color="purple"
          )
          v-tab(ripple :to="{ name: 'donation-list' }") Doacões
          v-tab(ripple :to="{ name: 'player-list' }") Usuários
    v-content
      v-container(fluid)
        transition(name="slide-y-transition" mode="out-in")
          router-view(:key="$route.name")
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class AdminComponent extends Vue {
  private beforeRouteEnter(to: any, from: any, next: any) {
    const token = localStorage.getItem('cords-token');
    if (token) {
      next();
      return;
    }
    next('/login');
  }
}
</script>

<style lang="sass" scoped>
.admin
  background: url('/img/1.png') !important
  background-size: cover !important
  position: fixed
  left: 0
  top: 0
  bottom: 0
  right: 0
  overflow: auto
  z-index: 2
</style>
