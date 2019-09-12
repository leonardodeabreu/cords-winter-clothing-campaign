<template lang="pug">
  .cords
    img(src="/img/bg_cords.jpg" width="100%")
    .cords__title Opss! Ocorreu um problema! Procure um membro do CBPGP.
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class CordsComponent extends Vue {
  private timer?: any = undefined;

  private startTimer(): void {
    if (this.timer) {
      clearTimeout(this.timer);
    }

    this.timer = setTimeout(() => {
      this.$router.push({ name: 'score' });
    }, 10000);
  }

  private beforeDestroy() {
    if (this.timer) {
      clearTimeout(this.timer);
    }
  }

  private mounted() {
    this.startTimer();
  }
}
</script>

<style lang="sass" scoped>
  .cords
    position: fixed
    left: 0
    top: 0
    bottom: 0
    right: 0
    overflow: hidden
    &__title
      position: absolute
      left: 50%
      top: 50%
      transform: translate(-50%, -50%)
      z-index: 3
      color: #fff
      font-size: 42px
      background: rgba(0,0,0,.3)
      padding: 16px
      border-radius: 4px
      text-shadow: 1px 1px 0 rgba(0,0,0,.5)
    &__email
      position: absolute
      left: 50%
      bottom: 20px
      transform: translateX(-50%)
      color: #fff
      font-size: 22px
      padding: 16px
      border-radius: 4px
      text-shadow: 1px 1px 0 rgba(0,0,0,.5)
      text-transform: uppercase
</style>
