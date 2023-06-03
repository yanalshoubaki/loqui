import { UserEntity } from "./entity";

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    user: UserEntity;
    currentUser: UserEntity;
    is_logged_in: boolean;
    stats: {
        following: number;
        messages: number;
        followers: number;
    };
};
