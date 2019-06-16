import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class Thor extends HeroBase implements Hero {
  public readonly id: number = 5;
  public readonly name: string = 'Thor';
  public readonly colors: Colors = {
    primary: 'blue-grey darken-3',
    secondary: 'red',
  };
  public readonly image: string = '/img/RAIDEN.png';
  public readonly background: string = '/img/fundo_do_thor.jpg';
}
