import {User} from '../users/user';
import {Order} from '../orders/order';

export type Message = {
  id: number
  user: User
  created_at: string,
  message: string
  title: string
  comments: Comment[]
  images: string
}

export type Comment = Message & {

}

export type SaveMessage = {
  postId: number;
  message: string;
  images?: FileList
}
