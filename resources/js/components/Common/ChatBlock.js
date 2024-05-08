import MessageSend from './MessageSend';
import MessageGet from './MessageGet';
import CredentialsContainerDiv from './Credentials';
import { useEffect, useRef, useState } from 'react';

export default function ChatBlock({
    userMessages,
    userChats,
    socket,
    textCredentialBtn,
    setTextCredentialBtn,
    credentialName,
    setCredentialName,
    credentialEmail,
    setCredentialEmail,
    credentialPhone,
    setCredentialPhone,
    userData,
    userProfile,
    mainUrl,
    scrollRef,
    scrollToBottom
}) {
    const [validateName, setValidateName] = useState(false);
    const [validateEmail, setValidateEmail] = useState(false);
    const [validatePhone, setValidatePhone] = useState(false);

    const [btnSaveEnabled, setBtnSaveEnabled] = useState(false)

    const validateEm = (email) => {
        return String(email)
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    };

    useEffect(() => {
        if (credentialName.length > 2) {
            setValidateName(true)
        } else {
            setValidateName(false)
        }
    }, [credentialName])

    useEffect(() => {
        if (credentialPhone.length > 8) {
            setValidatePhone(true)
        } else {
            setValidatePhone(false)
        }
    }, [credentialPhone])

    useEffect(() => {
        if (validateEm(credentialEmail)) {
            setValidateEmail(true)
        } else {
            setValidateEmail(false)
        }
    }, [credentialEmail])

    useEffect(() => {

        if (validateName == true && validateEmail == true && validatePhone == true) {
            setBtnSaveEnabled(true)
        } else {
            setBtnSaveEnabled(false)
            setTextCredentialBtn(false)
        }
    }, [validateName, validateEmail, validatePhone])


    const sendCredentials = async () => {
        if (btnSaveEnabled == true && textCredentialBtn != true) {
            const credentials = {
                name: credentialName,
                phone: credentialPhone,
                email: credentialEmail,
                userhash: userChats?.user_hash
            }

            socket.emit('message', {
                name: 'hash-credentials',
                data: credentials
            });
        }
    }

    const [filteredDatas, setFilteredDatas] = useState();
    const [resultFilteredData, setResultFilteredData] = useState();

    const filterByDate = () => {
        if (userMessages?.length > 0) {
            const monthNames = [
                'Январь',
                'Февраль',
                'Март',
                'Апрель',
                'Май',
                'Июнь',
                'Июль',
                'Август',
                'Сентябрь',
                'Октябрь',
                'Ноябрь',
                'Декабрь',
            ];
            const todayMonth = new Date().getMonth();
            const todayDay = new Date().getDate();

            const filteredMessageByDate = userMessages.reduce(
                (preData, message) => {
                    const month = new Date(message.created_at).getMonth();
                    const day = new Date(message.created_at).getDate();

                    //Тут определяем Сегодня и Вчера
                    let fullDayMonth = '';
                    if (day == todayDay && month == todayMonth) {
                        fullDayMonth = 'Сегодня';
                    } else if (day == todayDay - 1 && month == todayMonth) {
                        fullDayMonth = 'Вчера';
                    } else {
                        fullDayMonth = `${day} ${monthNames[month]}`;
                    }

                    if (!preData[fullDayMonth]) {
                        preData[fullDayMonth] = [];
                    }
                    preData[fullDayMonth].push(message);
                    return preData;
                },
                {},
            );

            setFilteredDatas(filteredMessageByDate);
            scrollToBottom();
        }
    };

    useEffect(() => {
        if (filteredDatas) {
            const groupArrays = Object.keys(filteredDatas).map(
                (date, value) => {
                    return {
                        date: date,
                        data: filteredDatas[date],
                    };
                },
            );

            setResultFilteredData(groupArrays);
        }
    }, [filteredDatas]);

    useEffect(() => {
        setTimeout(() => {
            scrollToBottom();
        }, 1000)
    }, [resultFilteredData]);

    useEffect(() => {
        filterByDate();
    }, [userMessages]);

    return (
        <div className="albg-view-6  algb-scroll-content">
            <div className="albg-scroll-subcontainer">
                {resultFilteredData?.map((item, index) => {
                    return (
                        <>
                            <div key={index} className="albg-date-time-container">
                                {item?.date}
                            </div>
                            {
                                item?.data?.length > 0 && item?.data?.map((item2, index2) => {
                                    if (item2.sender === 'client' && item2.msg_type == 'message') {
                                        return <MessageSend data={item2} key={index2} userProfile={userProfile} mainUrl={mainUrl} />;
                                    }
                                    if (item2.sender == 'operator' && item2.msg_type === "credential" || item2.msg_type === "credential_saved") {
                                        return <CredentialsContainerDiv
                                            key={index2}
                                            name={credentialName}
                                            setName={setCredentialName}
                                            phone={credentialPhone}
                                            setPhone={setCredentialPhone}
                                            email={credentialEmail}
                                            setEmail={setCredentialEmail}
                                            sendData={sendCredentials}
                                            validateName={validateName}
                                            validateEmail={validateEmail}
                                            validatePhone={validatePhone}
                                            btnSaveEnabled={btnSaveEnabled}
                                            textCredentialBtn={textCredentialBtn}
                                            userProfile={userProfile}
                                        />
                                    }
                                    if (item2.sender == 'operator' && item2.msg_type == 'message') {
                                        return <MessageGet data={item2} key={index2} userData={userData} mainUrl={mainUrl} />;
                                    }
                                })
                            }
                        </>)

                })
                }
            </div>
            <div ref={scrollRef} />
        </div>
    )
}