import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class Hulk extends HeroBase implements Hero {
  public readonly id: number = 2;
  public readonly name: string = 'Hulk';
  public readonly colors: Colors = {
    primary: 'green darken-3',
    secondary: 'green',
  };
  public readonly image: string = '/img/VERDE.png';
  public readonly background: string = '/img/fundo_do_hulk.jpg';
}
