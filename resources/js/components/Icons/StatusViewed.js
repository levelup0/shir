export default function StatusViewed({ w, h, bgColor }) {
  return (
    <svg
      width={w}
      height={h}
      viewBox="0 0 27 28"
      fill="none"
      xmlns="http://www.w3.org/2000/svg">
      <path d="M21.9375 7.25L10.125 20.75L5.0625 15.6875"
        stroke={bgColor}
        strokeWidth="2"
        strokeMiterlimit="10"
        strokeOpacity="0.9"
        strokeLinecap="square" />
    </svg>
  )
}