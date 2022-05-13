import React, {Fragment} from 'react';
import reactToWebComponent from "react-to-webcomponent";
import ReactDOM from "react-dom";
import PropTypes from "prop-types";

export default function Erreur404(props) {
    return (
        <Fragment>
            <div className="container container-404">
                <h1 className="h1-404">Erreur 404</h1>
                <p className="p-404">Cette page est introuvable</p>
                <a className="a-404" href={props.link}>voulez vous vous rendre a la page d'accueil</a>
            </div>
        </Fragment>
    );
}

Erreur404.propTypes = {
    link: PropTypes.any
}

customElements.define('erreur-404', reactToWebComponent(Erreur404, React, ReactDOM))