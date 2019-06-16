import httpService from './http.service';
import { PlayerDTO } from '@/entities/player.entity';

export class PlayerService {
  public static list(page: number = 1, searchTerm: string = '') {
    return httpService.get('player', {
      params: {
        page,
        limit: 15,
        paginate: 1,
        name: searchTerm,
      },
    });
  }

  public static getById(rfid: string) {
    return httpService.get('player/show', {
      params: {
        rfid,
      },
    });
  }

  public static delete(rfid: string) {
    return httpService.delete(`player/${rfid}`);
  }

  public static save(playerDTO: PlayerDTO) {
    if (playerDTO.id) {
      return httpService.put(`player/${playerDTO.rfid}`, playerDTO);
    }
    return httpService.post('player', playerDTO);
  }
}
