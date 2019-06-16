import { Hero, Colors } from './hero.interface';
import { HeroBase } from './hero.base';

export class HomemDeFerro extends HeroBase implements Hero {
  public readonly id: number = 6;
  public readonly name: string = 'Homem de Ferro';
  public readonly colors: Colors = {
    primary: 'red darken-3',
    secondary: 'orange',
  };
  public readonly image: string = '/img/JAIRO.png';
  public readonly background: string = '/img/fundo_do_homem_de_ferro.jpg';
}
