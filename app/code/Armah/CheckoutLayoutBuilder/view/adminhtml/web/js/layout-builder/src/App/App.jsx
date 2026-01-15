import React from 'react';
import BuilderContainer from './LayoutBuilder/BuilderContainer';
import CheckoutResolverContainer from './CheckoutResolver/CheckoutResolverContainer';

const App = (props) => {
    const { translations } = props;

    const APP_CONTAINER_ID = 'arbuilder-app-component';

    return (
        <div id={APP_CONTAINER_ID} className="arbuilder-app-component">
            <CheckoutResolverContainer builderContainerId={APP_CONTAINER_ID} translations={translations}/>
            <BuilderContainer containerId={APP_CONTAINER_ID} />
        </div>
    );
};

export default App;
