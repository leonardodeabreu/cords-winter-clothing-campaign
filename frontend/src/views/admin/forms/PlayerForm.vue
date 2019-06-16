<template lang="pug">
  .form
    v-text-field(
      label="Nome"
      color="green accent-2"
      v-model="DTO.name"
      )
    v-text-field(
      label="E-mail"
      color="green accent-2"
      v-model="DTO.email"
      )
    v-text-field(
      label="RFID"
      color="green accent-2"
      v-model="DTO.rfid"
      :disabled="!!$route.params.id"
      )
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { PlayerDTO } from '@/entities/player.entity';

@Component
export default class PlayerFormComponent extends Vue {
  @Prop({ type: Object })
  private DTO!: PlayerDTO;
}
</script>
