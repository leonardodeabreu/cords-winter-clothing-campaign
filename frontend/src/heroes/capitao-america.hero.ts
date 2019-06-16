import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class CapitaoAmerica extends HeroBase implements Hero {
  public readonly id: number = 1;
  public readonly name: string = 'Capitão América';
  public readonly colors: Colors = {
    primary: 'blue darken-3',
    secondary: 'red',
  };
  public readonly image: string = '/img/CAP.png';
  public readonly background: string = '/img/fundo_do_capitao.jpg';
}
