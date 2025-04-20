
// a simple class that translates resources into actual messages
import {keys} from './locale/resources';

export class Res {
  public static Get(key: string, fallback?: string): string {
    // get message from key
    if (keys[key]) {
      return keys[key];
    }

    // if not found, fallback, if not provided return NoRes
    return fallback || keys.NoRes;
  }
}
