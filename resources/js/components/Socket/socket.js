import { io } from 'socket.io-client';

//const socketPath = import.meta.env.MIX_SOCKET_PATH;

// "undefined" means the URL will be computed from the `window.location` object
/*const URL =
    process.env.NODE_ENV === 'production' ? 'http://localhost:4444' : 'http://localhost:4444';*/

    
const URL = process.env.MIX_SOCKET_PATH;  
export const socket = io(URL, { 
    withCredentials: true,
    transports: ['websocket', 'polling'], 
    // autoConnect: false
}); 
