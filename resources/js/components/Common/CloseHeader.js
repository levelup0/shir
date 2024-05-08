import IconMobileMsg from "../Icons/IconMobileMsg";
import LogoWithouTextNew from "../Icons/LogoWithouTextNew";

export default function CloseHeader({ userProfile, switchContainer, setSwitchContainer }) {
  return (
    <>
      <div
        style={{ backgroundColor: userProfile?.bg_color }}
        className={"algb-close-header-screen " + (switchContainer == true ? 'algb-close-container-hide' : '')}
        onClick={() => setSwitchContainer(true)}
      >
        <div className="albg-frame">
          <div
            style={{ color: userProfile?.text_color }}

            className="albg-text-wrapper">Напиши нам, мы онлайн!</div>
          <LogoWithouTextNew h={20} w={20} />
        </div>
      </div>

      <div
        style={{ backgroundColor: userProfile?.bg_color }}
        className={"close-header-screen-mobile " + (switchContainer == true ? 'algb-close-container-hide' : '')}
        onClick={() => setSwitchContainer(true)}
      >
        <div className="scene3d">
          <div className="object3d" id="obj1">
            <div id="im1" className="face3d" >
              <LogoWithouTextNew w={32} h={32} />
            </div>
            <div id="im2" className="face3d" >
              <IconMobileMsg />
            </div>
          </div>
        </div>
      </div>
    </>
  )
}