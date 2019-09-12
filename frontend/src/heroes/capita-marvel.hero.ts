import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class CapitaMarvel extends HeroBase implements Hero {
  public readonly id: number = 3;
  public readonly name: string = 'Capitã Marvel';
  public readonly colors: Colors = {
    primary: 'transparent',
    secondary: 'blue',
  };
  public readonly image: string = '/img/MUIE.png';
  public readonly background: string = '/img/BEM_VINDO.png';
}
