import { Boss } from './boss.interface';

export class Thanos implements Boss {
  public readonly name: string = 'Thanos';
  public readonly life?: number = undefined;
  public readonly lifeFactor: number = 0;
  public readonly image: string = '/img/thanos.png';
  public readonly background: string = '/img/3.jpg';
}
