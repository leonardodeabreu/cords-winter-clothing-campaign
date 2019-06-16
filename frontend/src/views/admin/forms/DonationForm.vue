<template lang="pug">
  .form
    v-select(
      :items="teams"
      item-text="name"
      item-value="id"
      label="Equipe"
      v-model="DTO.team_id"
      )
    v-text-field(
      label="Kilos"
      type="number"
      color="green accent-2"
      v-model="DTO.kilos"
      )
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { AxiosResponse } from 'axios';
import { DonationDTO } from '@/entities/donation.entity';
import { TeamService } from '@/services/team.service';

@Component
export default class DonationFormComponent extends Vue {
  @Prop({ type: Object })
  private DTO!: DonationDTO;

  private teams: any[] = [];

  private getTeams() {
    TeamService.list().then(({ data }: AxiosResponse) => {
      this.teams = data.data;
    });
  }

  private created() {
    this.getTeams();
  }
}
</script>
