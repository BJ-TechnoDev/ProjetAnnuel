import '../app'
import React, {Fragment} from 'react';
import {createRoot} from "react-dom/client";
import Hello from "../composant/hello";

function Home() {
    return (
        <Fragment>
            <Hello name={"moi"}/>
        </Fragment>
    );
}

export default Home;

const rootHome = createRoot(document.getElementById('app'));
rootHome.render(<Home/>);