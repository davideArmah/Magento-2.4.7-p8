import React, { useCallback } from 'react';
import InlineSVG from 'svg-inline-react';

import './styles/CheckoutItemComponent.less';

const dragIcon = require('@images/drag_icon.svg');

const CheckoutItemComponent = (props) => {
    const {
        translations,
        itemConfig,
        checkoutItemsConfig,
        changeCheckoutItemFrontendTitleAction,
        readonly
    } = props;

    const {
        staticTitle,
        dragIconTitle,
        defaultBlockTitles
    } = translations;

    const onTitleChange = useCallback((event) => {
        changeCheckoutItemFrontendTitleAction({
            name: itemConfig.i,
            frontendTitle: event.target.value
        });
    }, [changeCheckoutItemFrontendTitleAction, itemConfig.i]);

    const onInputMouseDown = (event) => {
        event.stopPropagation();
    };

    return (
        <div className="arbuilder-checkout-item">
            {itemConfig.static
            && <span className="arbuilder-static">{staticTitle}</span>}
            <span className="arbuilder-icon">
                <InlineSVG src={dragIcon} alt={dragIconTitle} />
            </span>

            <span className="arbuilder-title">{defaultBlockTitles[itemConfig.i]}</span>
            <div className="arbuilder-input-wrapper">
                <input
                    className="arbuilder-input"
                    onChange={onTitleChange}
                    onMouseDown={onInputMouseDown}
                    type="text"
                    value={checkoutItemsConfig[itemConfig.i] ? checkoutItemsConfig[itemConfig.i].frontendTitle: ''}
                    placeholder={translations.defaultBlockTitles[itemConfig.i]}
                    readOnly={readonly}
                />
            </div>
        </div>
    );
};

export default CheckoutItemComponent;
