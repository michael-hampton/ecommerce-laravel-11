import { UserNotification } from "./user-notification";

export type Type = {
    name: string;
    id: number;
    description: string
}

export type NotificationTypeCollection = {
    types: Type[],
    user_types: UserNotification[]
}