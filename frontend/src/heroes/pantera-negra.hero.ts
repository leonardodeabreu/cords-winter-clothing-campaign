import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class PanteraNegra extends HeroBase implements Hero {
  public readonly id: number = 4;
  public readonly name: string = 'Pantera Negra';
  public readonly colors: Colors = {
    primary: 'transparent',
    secondary: 'yellow darken-4',
  };
  public readonly image: string = '/img/PANTERO.png';
  public readonly background: string = '/img/BEM_VINDO.png';
}
