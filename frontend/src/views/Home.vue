<template lang="pug">
  .cords
    transition-group(name="slide-y-transition" mode="out-in")
      .cords__logo(v-if="step === 1" key="step-1")
        v-layout(column align-center justify-center)
          img(src="/img/logo_cords.png" height="240")
          .display-1.mt-3.white--text Apresenta:
      .cords__logo(v-else key="step-2")
        img(src="/img/logo_campanha.png" height="320")
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class TeamComponent extends Vue {
  private step: number = 1;
  private timer: any = null;

  private startTimer() {
    this.timer = setInterval(() => {
      this.step = this.step + 1;
      if (this.step === 3) {
        this.$router.push({ name: 'score' });
      }
    }, 5000);
  }

  private mounted() {
    this.startTimer();
  }

  private beforeDestroy() {
    if (this.timer) {
      clearInterval(this.timer);
    }
  }
}
</script>

<style lang="sass" scoped>
  .cords
    position: fixed
    left: 0
    right: 0
    top: 0
    bottom: 0
    background: #212121
    overflow: hidden
    &__logo
      position: absolute
      left: 50%
      top: 50%
      transform: translate(-50%, -50%)
</style>
