import { AxiosInstance } from 'axios';
import HttpBuilder from './http.builder';

const httpBuilder: HttpBuilder = new HttpBuilder();
httpBuilder.withRequestInterceptor();
httpBuilder.withResponseInterceptor();
const httpService: AxiosInstance = httpBuilder.build();

export default httpService;
