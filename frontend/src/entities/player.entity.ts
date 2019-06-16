import { PlayerService } from '@/services/player.service';
import { DataTableHeader } from './data-table-header.interface';
import PlayerForm from '@/views/admin/forms/PlayerForm.vue';

export interface PlayerDTO {
  id?: string;
  name: string;
  email: string;
  rfid: string;
}

export class PlayerEntity {
  public readonly service: any = PlayerService;
  public readonly title: string = 'Usuários';
  public readonly type: string = 'player';
  public readonly headers: DataTableHeader[] = [
    {
      text: 'Nome',
      align: 'left',
      sortable: false,
      value: 'name',
    },
  ];
  public readonly formComponent: any = PlayerForm;
}
