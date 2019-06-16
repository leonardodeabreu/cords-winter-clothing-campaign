import { Loki } from './loki.boss';
import { Ultron } from './ultron.boss';
import { Thanos } from './thanos.boss';
import { Boss } from './boss.interface';

export class BossFactory {
  // public createBoss(id: 1): Loki;
  // public createBoss(id: 2): Ultron;
  // public createBoss(id: 3): Thanos;

  public createBoss(id: number): Boss {
    if (id === 1) {
      return new Loki();
    }
    if (id === 2) {
      return new Ultron();
    }
    return new Thanos();
  }

  public createBossByScore(score: number) {
    if (score < 50) {
      return this.createBoss(1);
    }
    if (score < 150) {
      return this.createBoss(2);
    }
    return this.createBoss(3);
  }
}
