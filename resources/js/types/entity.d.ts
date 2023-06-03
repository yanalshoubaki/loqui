export interface MediaObjectEntity {
    id: number;
    media_path: string;
    media_type: string;
    media_name: string;
    media_size: string;
    media_extension: string;
    media_mime_type: string;
    created_at: string;
    updated_at: string;
}
export interface UserEntity {
    id: number;
    username: string;
    profile_image: MediaObjectEntity;
    name: string;
    email: string;
    status: number;
    created_at: string;
    updated_at: string;
}

export interface MessageEntity {
    id: number;
    sender: UserEntity;
    user: UserEntity;
    message: string;
    is_anon: number;
    is_new: boolean;
    created_at: string;
    replay?: ReplayEntity;
}

export interface ReplayEntity {
    id: number;
    message: MessageEntity;
    user: UserEntity;
    replay: string;
    image: MediaObjectEntity | boolean;
}
