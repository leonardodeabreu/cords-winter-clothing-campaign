import { Boss } from './boss.interface';

export class Ultron implements Boss {
  public readonly name: string = 'Ultron';
  public readonly life: number = 200;
  public readonly lifeFactor: number = 50;
  public readonly image: string = '/img/robo_rizadinho.png';
  public readonly background: string = '/img/2.jpg';
}
