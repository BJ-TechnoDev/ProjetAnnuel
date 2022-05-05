import '../app'
import React from 'react';
import {createRoot} from "react-dom/client";
import Hello from "../composant/hello";

function Home() {
    return (
        <div>
            <Hello />
        </div>
    );
}

export default Home;

const rootHome = createRoot(document.getElementById('app'));
rootHome.render(<Home/>);