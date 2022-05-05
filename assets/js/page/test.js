import '../app'
import React, {Component} from 'react';
import Hello from "../composant/hello";
import {createRoot} from "react-dom/client";

class Test extends Component {
    render() {
        return (
            <div>
                <Hello />
            </div>
        );
    }
}
export default Test;

const rootTest = createRoot(document.getElementById('test'));
rootTest.render(<Test />);