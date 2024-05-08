import React from 'react';
import { createRoot } from "react-dom/client";
import Project from './Project';

let channel = JSON.parse('<?php echo addslashes($hash_data) ?>');
//let channel = { channel_hash: 'sbDY_ZZ74t' }


//{hash_data :'1HNeOiZeFu'} // JSON.parse('<?php echo addslashes($hash_data) ?>');

export default function App() {
    return (
        <Project channel={channel} />
    );
}

window.onload = function () {
    var reactapp = document.createElement("div");
    document.body.appendChild(reactapp);
    const root = createRoot(reactapp);
    root.render(
        <App />
    );
}
//Оксицатин


