<template lang="pug">
  v-card(dark color="purple darken-3")
    v-btn(
      fab
      fixed
      right
      bottom
      color="purple"
      @click="goToForm"
      )
      v-icon add
    v-card-title
      strong {{ title }}
    v-divider
    .grey.darken-3
      v-text-field(
        solo
        flat
        hide-details
        v-model="searchTerm"
        append-icon="search"
        placeholder="Buscar..."
        color="purple accent-1"
        v-on:keyup.enter="list"
        )
      v-divider
    v-alert.ma-0(type="success" :value="this.$route.query.success") Operação realizada com sucesso!
    v-data-table(
      hide-actions
      :items="items"
      :headers="headers"
      no-data-text="Nenhum registro encontrado"
      )
      template(v-slot:items="props")
        tr(@click="editItem(props.item.rfid || props.item.id)")
          td(v-for="header in headers") {{ props.item[header.value] }}
    v-card-actions.grey.darken-4
      v-layout(justify-center)
        v-pagination(
        v-model="page"
        :length="lastPage"
        @input="list"
        )
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { UserService } from '@/services/user.service';
import { EntityFactory } from '@/entities/entity.factory';
import { PlayerEntity } from '@/entities/player.entity';
import { DonationEntity } from '@/entities/donation.entity';
import { AxiosResponse } from 'axios';
import { Location } from 'vue-router';

@Component
export default class AdminComponent extends Vue {
  private entityFactory: EntityFactory = new EntityFactory();
  private entity!: PlayerEntity | DonationEntity;
  private items: any[] = [];
  private page: number = 1;
  private lastPage: number = 1;
  private searchTerm: string = '';

  get title() {
    return this.entity ? this.entity.title : '';
  }

  get headers() {
    return this.entity ? this.entity.headers : [];
  }

  private goToForm() {
    this.$router.push({
      name: this.$route.name && this.$route.name.replace('-list', '-form'),
    });
  }

  private editItem(id: string) {
    this.$router.push({
      name: this.$route.name && this.$route.name.replace('-list', '-form'),
      params: {
        id,
      },
    });
  }

  private list() {
    this.entity.service.list(this.page, this.searchTerm).then(({ data }: AxiosResponse) => {
      this.page = data.meta.current_page;
      this.lastPage = data.meta.last_page;
      this.items = data.data;
    });
  }

  private created() {
    this.entity = this.entityFactory.createEntity(this.$route.meta.type);
    this.list();
  }
}
</script>
