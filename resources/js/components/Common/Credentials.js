import CheckMark from "../Icons/CheckMark";
import ThanksEm from "../Icons/ThanksEm";

/* eslint-disable react/prop-types */
export default function CredentialsContainerDiv({
  name,
  setName,
  phone,
  setPhone,
  email,
  setEmail,
  sendData,
  validateName,
  validateEmail,
  validatePhone,
  btnSaveEnabled,
  textCredentialBtn,
  userProfile
}) {
  return (
    <>
      <div className="algb-credentials-screen">
        <div className="text-before-credentials">Укажите ваши контакты, чтобы мы смогли ответить вам</div>
        <div
          style={{ 'box-shadow': '0 3px 10px 0 rgba(0,0,0,.08), 0 0 1px 0 rgba(0,0,0,.22), inset 0 2px 0 0 ' + userProfile?.bg_color }}
          className="algb-credentials-container"
        >
          <div className="albg-view-2">
            <div className="albg-div-2">
              <input className="albg-text-wrapper credential-mobile-input" value={name} onChange={(e) => setName(e.target.value)} placeholder="Ваше имя*" />
              {
                validateName == true ?
                  <div className="albg-check-mark">
                    <CheckMark w={20} h={20} />
                  </div> : null
              }

            </div>
            <div className="albg-div-2">
              <input className="albg-text-wrapper credential-mobile-input" value={phone} onChange={(e) => setPhone(e.target.value)} placeholder="Ваш телефон" />
              {
                validatePhone == true ?
                  <div className="albg-check-mark">
                    <CheckMark w={20} h={20} />
                  </div> : null
              }

            </div>
            <div className="albg-div-2">
              <input className="albg-text-wrapper credential-mobile-input" value={email} onChange={(e) => setEmail(e.target.value)} placeholder="Ваш e-mail" />
              {
                validateEmail == true ?
                  <div className="albg-check-mark">
                    <CheckMark w={20} h={20} />
                  </div> : null
              }
            </div>
          </div>
          <div


            className={"  " + (btnSaveEnabled == true && textCredentialBtn != true ? 'albg-div-wrapper' : 'algb-btn-send-credential-disabled')}
            style={
              (btnSaveEnabled == true && textCredentialBtn != true ? { backgroundColor: userProfile?.bg_color, color: userProfile?.text_color } : null)

            }
            onClick={(e) => sendData()}>
            {textCredentialBtn == true ? 'Спасибо' : 'Отправить'}
            {
              textCredentialBtn == true ? <ThanksEm w={21} h={20} /> : null
            }

          </div>
        </div>
        {textCredentialBtn == true ?
          <div className="text-before-credentials"> Теперь ваши сообщения не потеряются. Ответ операторов придет в чат и по указанным контактам.</div>
          : null}
      </div>
    </>
  );

}
