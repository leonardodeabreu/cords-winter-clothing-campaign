import { DonationService } from '@/services/donation.service';
import { DataTableHeader } from './data-table-header.interface';
import DonationForm from '@/views/admin/forms/DonationForm.vue';

export interface DonationDTO {
  id?: number;
  kilos: number;
  team_id: number;
}

export class DonationEntity {
  public readonly service: any = DonationService;
  public readonly title: string = 'Doações';
  public readonly type: string = 'donation';
  public readonly headers: DataTableHeader[] = [
    {
      text: 'Nome',
      align: 'left',
      sortable: false,
      value: 'name',
    },
  ];
  public readonly formComponent: any = DonationForm;
}
