export interface Colors {
  readonly primary: string;
  readonly secondary: string;
}

export interface Hero {
  readonly id: number;
  readonly name: string;
  readonly colors: Colors;
  readonly background: string;
  readonly image: string;
  position?: number;
  score?: number;
}
