import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class Thor extends HeroBase implements Hero {
  public readonly id: number = 5;
  public readonly name: string = 'Thor';
  public readonly colors: Colors = {
    primary: 'transparent',
    secondary: 'red',
  };
  public readonly image: string = '/img/RAIDEN.png';
  public readonly background: string = '/img/BEM_VINDO.png';
}
