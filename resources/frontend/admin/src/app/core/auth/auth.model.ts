import {IUser} from './user.model';

export type Login = {
  email: string
  password: string
}

// auth model
export interface IAuthInfo {
  payload?: IUser;
  accessToken?: string;
  refreshToken?: string;
  expiresAt?: number; // number of milliseconds of its life time
}

export const NewAuthInfo = (data: any): IAuthInfo => {
  return {
    payload: {
      email: data.payload.email,
      name: data.payload.name,
      id: data.payload.id,
    },
    accessToken: data.accessToken,
    refreshToken: data.refreshToken,
    // map expiresIn value to exact time stamp
    expiresAt: Date.now() + data.expiresIn * 1000,
  };
};

export const PrepSetSession = (auth: IAuthInfo): any => {
  // in real life, return only information the server might need
  return {
    auth: auth,
    cookieName: 'CrCookie', // this better be saved in external config
  };
};

export const PrepLogout = (): any => {
  return {
    cookieName: 'CrCookie',
  };
};
