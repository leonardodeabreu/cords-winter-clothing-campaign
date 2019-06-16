import { PanteraNegra } from '@/heroes/pantera-negra.hero';
import { Hero } from '@/heroes/hero.interface';

export class HeroService {
  public static getById(id: string): Promise<Hero> {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve(new PanteraNegra(1, 26));
      }, 1500);
    });
  }
}
