import { UserEntity } from "@/types/entity";
import * as React from "react";

type UserInfoProps = {
    user: UserEntity;
    stats: {
        following: number;
        messages: number;
        followers: number;
    };
} & React.HTMLAttributes<HTMLDivElement>;

export function UserInfo(props: UserInfoProps) {
    const { user, stats, ...otherProps } = props;
    return (
        <div {...otherProps}>
            <div className="bg-white py-8 px-4 rounded-lg shadow-md flex flex-col gap-5">
                <div>
                    <img
                        className="w-28 h-28 rounded-full mx-auto shadow-md"
                        src={user.profile_image?.media_path ?? ""}
                        alt={user.name}
                    />

                    <h2 className="text-center text-2xl font-semibold mt-3">
                        {user.name}
                    </h2>
                    <p className="text-center text-gray-600 mt-1">
                        {"@" + user.username}
                    </p>
                </div>
                <div className="flex justify-center mt-5 gap-3">
                    <button className="text-gray-800 hover:text-gray-700  flex flex-col justify-center items-center px-2">
                        <span className="text-lg font-bold">
                            {stats.messages}
                        </span>
                        <span>Messages</span>
                    </button>
                    <button className="text-gray-800 hover:text-gray-700 flex flex-col justify-center items-center px-2">
                        <span className="text-lg font-bold">
                            {stats.followers}
                        </span>
                        <span>Followers</span>
                    </button>
                    <button className="text-gray-800 hover:text-gray-700 flex flex-col justify-center items-center px-2">
                        <span className="text-lg font-bold">
                            {stats.following}
                        </span>
                        <span>Following</span>
                    </button>
                </div>
            </div>
        </div>
    );
}
