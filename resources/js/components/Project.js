import './MobileApp.css';
import './App.css';
import { useEffect, useRef, useState } from 'react';
import { io } from 'socket.io-client';
import { v4 as uuidv4 } from 'uuid';
import NewLogoLiveChat from './Icons/NewLogoLiveChat';
import BGChat from './Icons/BGChat';
import ChatBlock from './Common/ChatBlock';
import CloseHeader from './Common/CloseHeader';
import CloseIcon from './Icons/CloseIcon';
import BtnSendMobile from './Icons/BtnSendMobile';
import StickerMainIcon from './lib/sticker-parse/icons/StickerMainIcon';
import StickerContainer from './Common/StickerContainer';
import StickerContainerMobile from './Common/StickerContainerMobile';
import StickerMainMobileIcon from './lib/sticker-parse/icons/StickerMainMobileIcon';

export default function Project({ channel }) {
    //Проверям хеш канала
    if (channel?.channel_hash == null || channel?.channel_hash == "") {
        console.error("AlbiReo | Widget hash not found");
        return;
    }

    //Тут проверяем чтобы этот channel hash также был на локал сторейджом
    const algb_channel_hash = localStorage.getItem('algb_channel_hash');
    if (algb_channel_hash == null || typeof algb_channel_hash == 'undefined' || algb_channel_hash == "") {
        //Тут удаляем локальную hash
        localStorage.removeItem('algb_user_hash')
        localStorage.setItem('algb_channel_hash', channel?.channel_hash);
    } else {
        // Если есть channel hash То тогда проверяем с глобальным хашом
        if (algb_channel_hash != channel?.channel_hash) {
            //То тогда опять удалим локальную хаш и вообще все удалим
            localStorage.removeItem('algb_user_hash')
            localStorage.setItem('algb_channel_hash', channel?.channel_hash);
        }
    }

    const [socket, setSocket] = useState(null)
    const URL = process.env.MIX_SOCKET_PATH;
    const mainUrl = process.env.MIX_APP_MAIN_CORE;

    //Это текст который вводит пользователь
    const textRef = useRef();

    //BackData
    const [userChats, setUserChats] = useState("");
    const userHashRef = useRef();

    const [userRooms, setUserRooms] = useState("");
    const userRoomsRef = useRef();

    const [userProfile, setUserProfile] = useState(null);
    const userProfileRef = useRef();

    const [userMessages, setUserMessages] = useState([]);
    const userMessagesRef = useRef();

    const [userData, setUserData] = useState("");
    const userDataRef = useRef();;
    //End Back Data

    //Container control
    const [switchContainer, setSwitchContainer] = useState(false)
    const switchContainerRef = useRef();

    //End Container control

    //Credentials
    const [credentialName, setCredentialName] = useState("")
    const [credentialPhone, setCredentialPhone] = useState("")
    const [credentialEmail, setCredentialEmail] = useState("")
    const [textCredentialBtn, setTextCredentialBtn] = useState(false);
    // End credentials

    //StickerShowHide
    const [stickersContainerShow, setStickerContainerShow] = useState(false);

    //For messages
    const scrollRef = useRef(null);
    useEffect(() => {
        if (userChats != null) {
            if (userChats?.name != null && userChats?.name != "") {
                setCredentialName(userChats?.name)
            }
            if (userChats?.email != null && userChats?.email != "") {
                setCredentialEmail(userChats?.email)
            }
            if (userChats?.phone != null && userChats?.phone != "") {
                setCredentialPhone(userChats?.phone)
            }
            userHashRef.current = userChats
        }
    }, [userChats])


    useEffect(() => {
        userProfileRef.current = userProfile
    }, [userProfile])

    useEffect(() => {
        if (userData) {
            userDataRef.current = userData
        }
    }, [userData])

    useEffect(() => {
        if (userRooms) {
            userRoomsRef.current = userRooms
        }
    }, [userRooms])

    useEffect(() => {
        if (userMessages) {
            userMessagesRef.current = userMessages
        }
    }, [userMessages])

    /**
     * Функция отвечает за просмотра сообщении
     * Просмотра сообщении оператора
     * Проверяем по контейнеру, если открытый то видимо видел))
     */
    const checkLookedMsg = (msg) => {
        const _userChatsRef = userHashRef.current;
        const _switchContainerRef = switchContainerRef.current;

        if (_switchContainerRef == true) {
            socket.emit('message', {
                name: 'message-looked-client',
                user_room_id: msg.user_room_id,
                user_hash: _userChatsRef?.user_hash,
            })
        }
    }

    const updateMessage = (msg, type) => {
        const currentUserMessage = userMessagesRef.current
        if (currentUserMessage.length > 0) {
            if (type == 'client') {
                const updatedMessage = currentUserMessage.map((value, index) => {
                    if (value?.uuid == msg?.uuid) {
                        return { ...value, status: msg.status }
                    }
                    return value
                })
                setUserMessages(updatedMessage)
            }

            if (type == 'operator') {
                const updatedMessageD = [...currentUserMessage, msg];
                setUserMessages(updatedMessageD);
                //Теперь проверяем просмотрел ли пользователь сообщении оператора
                checkLookedMsg(msg)
            }

            if (type == 'viwed_message') {
                const updatedMessage = currentUserMessage.map((value, index) => {
                    if (value?.status == 'deliver') {
                        return { ...value, status: 'viewed' }
                    }
                    return value
                })
                setUserMessages(updatedMessage)
            }
        }
    }

    useEffect(() => {
        if (socket != null) {
            function onConnect() {
                const userHash = localStorage.getItem('algb_user_hash')
                socket.emit('message', {
                    name: 'login',
                    user_hash: userHash,
                })

                //Показывает разницу в минутах
                var offset = new Date().getTimezoneOffset();
                console.log("offset");
                console.log(offset);

                const newDate = new Date()

                console.log("newDate", newDate.getUTCMilliseconds())
            }

            function onDisconnect() {
                console.log("disocnnect")
            }
            function onMessage(msg) {
                switch (msg?.name) {
                    /**
                     * Когда с сокет сервера приходит ответа на существовании 
                     * userhash. Если его нет то начинает создавать новую
                     * И также все основные информации тут выставлются
                     */
                    case 'userhash':
                        if (msg?.data?.type == "newhash") {
                            //"Это новый пользователь"
                            setUserProfile(msg?.data?.user_profile);
                            setUserMessages(msg?.data?.user_messages)
                            setUserChats(msg?.data?.user_chats)
                            setUserRooms(msg?.data?.user_rooms)
                            //Тут как раз проверяем новых хаш
                            localStorage.setItem('algb_user_hash', msg?.data?.user_chats?.user_hash);

                        }

                        if (msg?.data?.type == "currenthash") {
                            // Тут уже выставляем историю переписок
                            setUserProfile(msg?.data?.user_profile);
                            setUserMessages(msg?.data?.user_messages)
                            setUserRooms(msg?.data?.user_rooms)
                            setUserChats(msg?.data?.user_chats)
                            setTextCredentialBtn(true);
                            setUserData(msg?.data?.user)
                        }
                        break;
                    /**
                     * Когда с сокет сервера приходит запрос на успех регистрации данные 
                     * Credentials
                     */
                    case 'credential':
                        setTextCredentialBtn(true)
                        break;
                    /**
                     * Когда с сокет сервера приходит ответ на сообщение успеха.
                     */
                    case 'update_message':
                        updateMessage(msg?.data?.data, 'client')
                        break;

                    case 'connect-user-response':
                        setUserRooms(msg?.data?.user_room)
                        setUserData(msg?.data?.user)
                        break;

                    case 'disconnect-user-response':
                        setUserRooms(msg?.data?.user_room)
                        setUserData("")
                        break;

                    case 'update_message_operator':
                        updateMessage(msg?.data?.data, 'operator')
                        break

                    //Это когда от оператора приходит запрос на то что все сообщения было просмотрена
                    case 'update_message_operator_all_viwed':
                        updateMessage(msg?.data?.data, 'viwed_message')
                        break
                }
            }

            socket.on('connect', onConnect);
            socket.on('message', onMessage);
            socket.on("connectedToRoom1", () => {
                console.log("A new user has joined room1");
            });

            socket.on('disconnect', onDisconnect);
            return () => {
                socket.off('connect', onConnect);
                socket.off('disconnect', onDisconnect);
                socket.off('message', onMessage);
            };
        }
    }, [socket])

    useEffect(() => {
        const newSocket = io(URL, {
            // reconnectionDelayMax: 10000,
            withCredentials: true,
            transports: ['websocket', 'polling'],
            query: {
                "hash_channel": channel?.channel_hash
            }
            // autoConnect: false
        });

        setSocket(newSocket)

        return () => {
            socket.off('disconnect', onDisconnect);
        };

        // return socket.disconnect()

    }, []);

    const getCurrentTime = () => {
        return new Date().toLocaleTimeString('en-US', {
            hour12: false,
            hour: "numeric",
            minute: "numeric"
        });
    }

    const createUuid = () => {
        return uuidv4()
    }

    const sendMessage = (msg) => {
        const newMessage = {
            uuid: createUuid(),
            msg: msg,
            msg_time: getCurrentTime(),
            msg_type: 'message',
            sender: 'client',
            status: 'in_progress',
            user_room_id: userRooms?.id,
            created_at: new Date()
        }
        setUserMessages([...userMessages, newMessage])

        socket.emit('message', {
            name: 'send_message',
            data: {
                msg: msg,
                user_hash: userChats?.user_hash,
                uuid: newMessage?.uuid,
                sender: 'client',
            }
        });
    }

    useEffect(() => {
        if (typeof switchContainer != 'undefined') {
            switchContainerRef.current = switchContainer
        }
    }, [switchContainer])

    const createMessage = async () => {
        const inputData = textRef.current.value;
        if (inputData.length > 0 && inputData != null) {
            sendMessage(inputData)
            textRef.current.value = ""
        }
    };

    const onFormSubmit = async e => {
        if (e.keyCode == 13 && e.shiftKey == false) {
            e.preventDefault();
            const inputData = textRef.current.value;
            if (inputData.length > 0 && inputData != null) {
                sendMessage(inputData)
                textRef.current.value = ""
            }
        }

    };

    const setSticker = (sticker) => {
        const old_value = textRef.current.value
        const newValue = old_value + "" + sticker;
        textRef.current.value = newValue;
        textRef.current.focus();
        setStickerContainerShow(false)

    }

    const scrollToBottom = () => {
        scrollRef.current?.scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });
    };

    useEffect(() => {
        scrollToBottom()
    }, [switchContainer])

    return (
        <div className={"algb-container " + (switchContainer == true ? 'left-container' : '')}>
            {/* Close Header */}
            <CloseHeader
                switchContainer={switchContainer}
                setSwitchContainer={setSwitchContainer}
                userProfile={userProfile}
            />
            {/* End Close Header */}
            <div

                className={"alg-screen " + (switchContainer == false ? 'algb-close-container-hide' : '')}>
                {/* Header */}
                <div className="algb-close-icon-container" onClick={() => setSwitchContainer(false)}>
                    <CloseIcon w={28} h={28} bgColor={userProfile?.bg_color} />
                </div>

                <div className="albg-view">
                    {
                        userProfile != null ?
                            <div style={{ backgroundColor: userProfile?.bg_color }} className="albg-image">
                                <BGChat bgColor={userProfile?.text_color} />
                            </div> : <div style={{ backgroundColor: '#292727' }} className="albg-image">
                                <BGChat bgColor={userProfile?.text_color} />
                            </div>
                    }

                    <div className="albg-div">
                        <div className="albg-div-2">
                            <div className='mobile-close-item-container' onClick={() => setSwitchContainer(false)}>
                                <CloseIcon bgColor={userProfile?.text_color} w={28} h={28} />
                            </div>
                            <div className="">
                                {
                                    userData != null && userData != "" ?
                                        <div className="algb-avatar-container">
                                            <img className="albg-avatar-image" alt="Image" src={userData?.avatar} />
                                            <div className="algb-avatar-online-container" style={{ backgroundColor: userProfile?.bg_color }} ><div className="algb-avatar-online-icon"></div></div>
                                        </div> :
                                        null
                                }
                            </div>
                            <div className="albg-view-2" >
                                <div className="albg-text-wrapper header-title" style={{ color: userProfile?.text_color }}>
                                    {userData != null && userData != "" ? userData?.nickname : 'Отправьте нам сообщение'}
                                </div>
                                {userData != null ?
                                    <div className="albg-text-wrapper-2"
                                        style={{ color: userProfile?.text_color }}
                                    >
                                        {userData != null && userData != "" ? userData?.position : ''}
                                    </div> : null}
                            </div>
                        </div>
                    </div>
                </div>
                <div className="albg-view-3">
                    <a className="v3-businness-msg" target="_blank" href={process.env.MIX_APP_MAIN_URL}>
                        <div className="albg-text-wrapper-3">Бизнес-мессенджер</div>
                        <NewLogoLiveChat height={15} w={70} textColor={'#000'} />
                    </a>
                </div>
                {/* Body */}
                <div className='algb-second-container'>
                    {/* Message Block */}
                    <ChatBlock
                        userMessages={userMessages}
                        userChats={userChats}
                        socket={socket}
                        userProfile={userProfile}
                        textCredentialBtn={textCredentialBtn}
                        setTextCredentialBtn={setTextCredentialBtn}

                        credentialName={credentialName}
                        setCredentialName={setCredentialName}
                        credentialEmail={credentialEmail}
                        setCredentialEmail={setCredentialEmail}
                        credentialPhone={credentialPhone}
                        setCredentialPhone={setCredentialPhone}
                        userData={userData}
                        mainUrl={mainUrl}
                        scrollRef={scrollRef}
                        scrollToBottom={scrollToBottom}
                    />

                    {/* Text Input Container */}
                    <form onSubmit={onFormSubmit} className="albg-view-10-footer">
                        <textarea
                            ref={textRef}
                            autoFocus
                            rows="4"
                            cols="2"
                            className="albg-text-wrapper-6"
                            maxLength="1000"
                            onKeyDown={onFormSubmit}
                            placeholder="Введите сообщение"
                        />
                        <div className="algb-button-send" >
                            <div className='algb-footer-containers-mobile'>
                                <div className='algb-footer-items-mobile'>
                                    <div className='algb-footer-skicker-main-mobile' onClick={() => setStickerContainerShow(!stickersContainerShow)}>
                                        <StickerMainMobileIcon w={32} h={32} />
                                    </div>
                                </div>
                            </div>
                            <span className="algb-btn-send-mobile-span" onClick={() => createMessage()}>
                                <BtnSendMobile w={32} h={32} fill={userProfile?.bg_color} />
                            </span>
                            <span onClick={() => createMessage()}>
                                <svg
                                    className='btn-send-hover'
                                    width="40"
                                    height="40"
                                    fill={`${userProfile?.bg_color}`}
                                    viewBox="0 0 40 40"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 3.75C11.0258 3.75 3.75 11.0258 3.75 20C3.75 28.9742 11.0258 36.25 20 36.25C28.9742 36.25 36.25 28.9742 36.25 20C36.25 11.0258 28.9742 3.75 20 3.75ZM27.1375 20.3633C27.0219 20.4798 26.8844 20.5725 26.733 20.6359C26.5816 20.6994 26.4191 20.7324 26.255 20.733C26.0908 20.7337 25.9281 20.702 25.7762 20.6397C25.6242 20.5775 25.4861 20.486 25.3695 20.3703L21.25 16.2828V26.7188C21.25 27.0503 21.1183 27.3682 20.8839 27.6026C20.6495 27.8371 20.3315 27.9688 20 27.9688C19.6685 27.9688 19.3505 27.8371 19.1161 27.6026C18.8817 27.3682 18.75 27.0503 18.75 26.7188V16.2828L14.6305 20.3703C14.5138 20.4859 14.3755 20.5775 14.2235 20.6396C14.0715 20.7018 13.9087 20.7335 13.7445 20.7327C13.5802 20.732 13.4177 20.6989 13.2663 20.6354C13.1148 20.5719 12.9773 20.4792 12.8617 20.3625C12.7461 20.2458 12.6546 20.1076 12.5924 19.9555C12.5302 19.8035 12.4986 19.6407 12.4993 19.4765C12.5 19.3123 12.5331 19.1498 12.5966 18.9983C12.6601 18.8468 12.7529 18.7094 12.8695 18.5938L19.1195 12.3914C19.3537 12.1591 19.6701 12.0287 20 12.0287C20.3299 12.0287 20.6463 12.1591 20.8805 12.3914L27.1305 18.5938C27.2473 18.7094 27.3401 18.8469 27.4037 18.9985C27.4673 19.1501 27.5003 19.3127 27.501 19.4771C27.5016 19.6414 27.4699 19.8043 27.4075 19.9564C27.3451 20.1084 27.2534 20.2467 27.1375 20.3633Z"
                                    />
                                </svg>
                            </span>


                        </div>
                    </form>
                    <div className='algb-footer-containers'>
                        <div className='algb-footer-items'>
                            <div className='algb-footer-skicker-main' onClick={() => setStickerContainerShow(!stickersContainerShow)}>
                                <StickerMainIcon w={24} h={24} />
                            </div>
                        </div>
                    </div>
                    {
                        stickersContainerShow == true ?
                            <StickerContainer setSticker={setSticker} />
                            : null
                    }

                </div>
            </div>
        </div >

    );
}
