import httpService from './http.service';
import { LoginDTO } from '@/views/admin/LoginDTO';

export class LoginService {
  public static auth(loginDTO: LoginDTO) {
    return httpService.post('auth/login', loginDTO);
  }
}
