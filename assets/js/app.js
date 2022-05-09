// any CSS you import will output into a single css file (app.scss in this case)
import '../styles/app.scss';

//lib js
import '../bootstrap';

//react root
import {createRoot} from "react-dom/client";
import React from "react";
import Home from "./page/home";

if (document.getElementById('home')){
    const rootHome = createRoot(document.getElementById('home'));
    rootHome.render(<Home/>);
}