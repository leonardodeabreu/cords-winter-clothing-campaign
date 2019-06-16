import httpService from './http.service';

export class UserService {
  public static list() {
    return httpService.get('user');
  }
}
