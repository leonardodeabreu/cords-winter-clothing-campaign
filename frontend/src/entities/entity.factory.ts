import { PlayerEntity } from './player.entity';
import { DonationEntity } from './donation.entity';

export class EntityFactory {
  // public createEntity(type: 'player'): PlayerEntity;
  // public createEntity(type: 'donation'): DonationEntity;

  public createEntity(type: string): PlayerEntity | DonationEntity {
    if (type === 'player') {
      return new PlayerEntity();
    }
    return new DonationEntity();
  }
}
