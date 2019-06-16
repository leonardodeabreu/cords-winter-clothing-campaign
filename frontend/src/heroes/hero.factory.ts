import { CapitaoAmerica } from './capitao-america.hero';
import { Hulk } from './hulk.hero';
import { CapitaMarvel } from './capita-marvel.hero';
import { PanteraNegra } from './pantera-negra.hero';
import { Thor } from './thor.hero';
import { HomemDeFerro } from './homem-de-ferro.hero';
import { Hero } from './hero.interface';

export class HeroFactory {
  // public createHero(id: 1, position: number, score: number): CapitaoAmerica;
  // public createHero(id: 2, position: number, score: number): Hulk;
  // public createHero(id: 3, position: number, score: number): CapitaMarvel;
  // public createHero(id: 4, position: number, score: number): PanteraNegra;
  // public createHero(id: 5, position: number, score: number): Thor;
  // public createHero(id: 6, position: number, score: number): HomemDeFerro;

  public createHero(id: number, position: number, score: number): Hero {
    position = Math.round(position);

    if (id === 1) {
      return new CapitaoAmerica(position, score);
    }
    if (id === 2) {
      return new Hulk(position, score);
    }
    if (id === 3) {
      return new CapitaMarvel(position, score);
    }
    if (id === 4) {
      return new PanteraNegra(position, score);
    }
    if (id === 5) {
      return new Thor(position, score);
    }
    return new HomemDeFerro(position, score);
  }
}
