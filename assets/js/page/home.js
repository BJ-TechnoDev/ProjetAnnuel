import '../app'
import React, {Component} from 'react';
import Hello from "../composant/hello";
import {createRoot} from "react-dom/client";

class Home extends Component {
    render() {
        return (
            <div>
                <Hello/>
            </div>
        );
    }
}

export default Home;


const root = createRoot(document.getElementById('app'));
root.render(<Home />);
