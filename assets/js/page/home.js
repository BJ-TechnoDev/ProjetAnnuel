import React, {Fragment} from 'react';
import reactToWebComponent from "react-to-webcomponent";
import ReactDOM from "react-dom";
import PropTypes from "prop-types";

export default function Home(props) {
    return (
        <Fragment>
            <h1>Hello {props.name}</h1>
        </Fragment>
    );
}
/* si props faire comme ceci ajouter le import et props dans la parenthese de la fonction*/
Home.propTypes = {
    name: PropTypes.any
}

//todo : changer le need avec le nome du composant (un tiret obligatoire et pas de maj)
customElements.define('home-component', reactToWebComponent(Home, React, ReactDOM))