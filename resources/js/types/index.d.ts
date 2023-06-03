import { UserEntity } from "./entity";

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    user: UserEntity;
};
