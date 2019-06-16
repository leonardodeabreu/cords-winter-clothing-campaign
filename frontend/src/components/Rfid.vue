<template lang="pug">
  .input-rfid
    input(
      type="text"
      ref="inputRfid"
      maxlength="10"
      v-model="rfid"
      @input="showTeamInfo"
      )
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class TeamComponent extends Vue {
  public $refs: any;
  private rfid: string = '';
  private timer: any = undefined;
  private timeout: any = undefined;

  private eternalFocus() {
    this.timer = setInterval(() => {
      if (this.$refs.inputRfid) {
        this.$refs.inputRfid.focus();
      }
    }, 10);
  }

  private showTeamInfo() {
    if (this.rfid.length === 0) {
      return;
    }
    this.rfid = parseFloat(this.rfid).toString();
    if (this.timeout) {
      clearTimeout(this.timeout);
    }
    this.timeout = setTimeout(() => {
      this.$router.push({
        name: 'team',
        params: {
          team: this.rfid,
        },
      });
      this.rfid = '';
    }, 500);
  }

  private beforeDestroy() {
    if (this.timeout) {
      clearTimeout(this.timeout);
    }
    if (this.timer) {
      clearInterval(this.timer);
    }
  }

  private mounted() {
    this.eternalFocus();
  }
}
</script>

<style lang="sass" scoped>
.input-rfid
  position: fixed
  left: 0
  top: 0
  bottom: 0
  right: 0
  background: red
  z-index: 101
  opacity: 0
  input
    width: 100%
    height: 100%
    font-size: 172px
    background: white
</style>
