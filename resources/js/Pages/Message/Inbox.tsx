import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import { UserInfo } from "@/Components/UserInfo";
import { MessageEntity } from "@/types/entity";
import MessageCard from "@/Components/MessageCard";
import Message from "@/Components/Message";

type InboxProps = {
    stats: {
        following: number;
        messages: number;
        followers: number;
    };
    messages: {
        data: MessageEntity[];
    };
} & PageProps;

export default function Inbox(props: InboxProps) {
    const { user, stats, messages, ...rest } = props;
    return (
        <AuthenticatedLayout user={user}>
            <Head title="Inbox" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex gap-12 flex-wrap flex-col md:flex-row justify-between">
                        <UserInfo className="w-2/6" user={user} stats={stats} />
                        <div className="w-7/12">
                            <div>
                                {messages.data.map((message: MessageEntity) => {
                                    return (
                                        <Message.WithoutReplay
                                            message={message}
                                            key={message.id}
                                        />
                                    );
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
