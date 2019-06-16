import httpService from './http.service';
import { DonationDTO } from '@/entities/donation.entity';

export class DonationService {
  public static list(page: number = 1, searchTerm: string = '') {
    return httpService.get('donation', {
      params: {
        page,
        limit: 15,
        paginate: 1,
        name: searchTerm,
      },
    });
  }

  public static getById(id: string) {
    return httpService.get(`donation/${id}`);
  }


  public static save(donationDTO: DonationDTO) {
    return httpService.post('donation', donationDTO);
  }

  public static getByTeam() {
    return httpService.get('donation/byTeam');
  }

  public static getAllKilos() {
    return httpService.get('donation/allKilos');
  }
}
