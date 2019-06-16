import axios, { AxiosInstance, AxiosRequestConfig, AxiosError, AxiosResponse } from 'axios';

export default class HttpBuilder {
  private readonly instance!: AxiosInstance;

  constructor(private readonly baseUrl: string = process.env.VUE_APP_BASE_URL) {
    this.instance = axios.create({
      baseURL: this.baseUrl,
    });
  }

  public withRequestInterceptor(onFulfilled?: (value: any) => any | Promise<any>): void {
    this.instance.interceptors.request.use((config: AxiosRequestConfig) => {
      const token: string | null = localStorage.getItem('cords-token');
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      return onFulfilled ? onFulfilled(config) : config;
    });
  }

  public withResponseInterceptor(
    onFulfilled?: (value: any) => any | Promise<any>,
    onRejected?: (error: any) => any,
  ): void {
    this.instance.interceptors.response.use((response: AxiosResponse) => {
      return onFulfilled ? onFulfilled(response) : response;
    }, (error: AxiosError) => {
      error = onRejected ? onRejected(error) : error;
      return Promise.reject(error);
    });
  }

  public build(): AxiosInstance {
    return this.instance;
  }
}
