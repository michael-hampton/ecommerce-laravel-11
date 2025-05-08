import { User } from "../users/user";

export type Notifications = {
    message: string;
    user: User
    created_at: string,
    id: string
}