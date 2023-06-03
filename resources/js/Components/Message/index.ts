import WithReplay from "./WithReplay";
import WithoutReplay from "./WithoutReplay";

type MessageProps = {
    children: React.ReactNode | React.ReactNode[];
};

const Message = (props: MessageProps) => {
    return props.children;
};

Message.WithReplay = WithReplay;
Message.WithoutReplay = WithoutReplay;
export default Message;
