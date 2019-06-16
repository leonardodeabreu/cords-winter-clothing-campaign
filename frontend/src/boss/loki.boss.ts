import { Boss } from './boss.interface';

export class Loki implements Boss {
  public readonly name: string = 'Loki';
  public readonly life: number = 50;
  public readonly lifeFactor: number = 0;
  public readonly image: string = '/img/loki.png';
  public readonly background: string = '/img/1.jpg';
}
