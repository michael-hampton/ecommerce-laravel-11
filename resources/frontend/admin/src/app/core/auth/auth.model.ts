import { Seller } from '../../types/seller/seller';
import {IUser} from './user.model';

export type Login = {
  email: string
  password: string
}

// auth model
export interface IAuthInfo {
  profile?: Seller;
  payload?: IUser;
  accessToken?: string;
  refreshToken?: string;
  expiresAt?: number; // number of milliseconds of its life time
}

export const NewAuthInfo = (data: any): IAuthInfo => {
  console.log('profile', data.profile)
  const obj = {
    payload: {
      email: data.user.email,
      name: data.user.name,
      id: data.user.id,
      role: data.user.utype,
      image: data.profile.profile_picture ? data.profile.profile_picture : data.user.image,
      profile: data.profile
    },
    accessToken: data.token,
    //refreshToken: data.refreshToken,
    // map expiresIn value to exact time stamp
    //expiresAt: Date.now() + data.expiresIn * 1000,
  };

  console.log('obj', obj)

  return obj
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
