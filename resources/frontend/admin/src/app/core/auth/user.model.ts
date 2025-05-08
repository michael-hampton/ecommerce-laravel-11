import {RoleEnum} from '../../types/users/role.enum';

export interface IUser {
  id: string;
  email: string;
  name?: string;
  role: RoleEnum;
  image: string
}
