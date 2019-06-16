import httpService from './http.service';

export class TeamService {
  public static list() {
    return httpService.get('team');
  }

  public static getById(id: number) {
    return httpService.get(`team/${id}`);
  }
}
