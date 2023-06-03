import { FormEventHandler, useEffect, useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/react";
import { UserInfo } from "@/Components/UserInfo";
import { UserEntity } from "@/types/entity";

import { PageProps } from "@/types";
import { map } from "lodash";

type Props = {
    following: UserEntity[];
    follower: UserEntity[];
} & PageProps;

const Follow = (props: Props) => {
    const { user, currentUser, stats, following, follower } = props;
    const page = usePage();
    const url = new URL(page.url, window.location.origin);
    const [activeTab, setActiveTab] = useState(
        url.searchParams.get("tab") || "following"
    );
    const [users, setUsers] = useState(following);
    const handleActiveTab = (tab: string) => {
        setActiveTab(tab);
        if (tab === "following") {
            setUsers(following);
        } else {
            setUsers(follower);
        }
    };
    useEffect(() => {
        if (activeTab === "following") {
            setUsers(following);
        } else {
            setUsers(follower);
        }
        url.searchParams.set("tab", activeTab);
        window.history.replaceState({}, "", url.toString());
    }, [activeTab]);
    return (
        <>
            <Head title="Inbox" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex gap-12 flex-wrap flex-col md:flex-row justify-between">
                        <UserInfo className="w-2/6" user={user} stats={stats} />
                        <div className="w-7/12">
                            <div className="flex flex-col gap-7">
                                <div>
                                    <nav className="flex flex-col sm:flex-row gap-3">
                                        <button
                                            onClick={(e) =>
                                                handleActiveTab("following")
                                            }
                                            className={
                                                activeTab === "following"
                                                    ? "text-gray-600  py-2 px-6 block bg-gray-200 focus:outline-none  rounded-lg font-medium "
                                                    : "text-gray-600  py-2 px-6 block  focus:outline-none  rounded-lg font-medium"
                                            }
                                        >
                                            Following{" "}
                                            <span>{following.length}</span>
                                        </button>
                                        <button
                                            onClick={(e) =>
                                                handleActiveTab("followers")
                                            }
                                            className={
                                                activeTab === "followers"
                                                    ? "text-gray-600  py-2 px-6 block  bg-gray-200  focus:outline-none  rounded-lg font-medium "
                                                    : "text-gray-600  py-2 px-6 block  focus:outline-none  rounded-lg font-medium"
                                            }
                                        >
                                            Followers{" "}
                                            <span>{follower.length}</span>
                                        </button>
                                    </nav>
                                </div>
                                <div className="flex flex-col gap-5">
                                    {map(users, (user) => {
                                        return (
                                            <div className="flex items-start px-4 py-6 bg-white  rounded-lg">
                                                <div className="">
                                                    <div className="flex flex-row">
                                                        <img
                                                            className="w-12 h-12 rounded-full object-cover mr-4 shadow"
                                                            src={
                                                                user
                                                                    .profile_image
                                                                    .media_path
                                                            }
                                                            alt="avatar"
                                                        />
                                                        <div className="flex items-center justify-between flex-col">
                                                            <h2 className="text-lg font-semibold text-gray-900 -mt-1">
                                                                {user.name}
                                                            </h2>
                                                            <small className="text-sm text-gray-700">
                                                                {"@" +
                                                                    user.username}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Follow;
