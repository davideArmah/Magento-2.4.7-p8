// Copyright © Stripe, Inc
//
// @package    StripeIntegration_Payments
// @version    3.4.1

var stripe = {

    // Properties
    version: "3.4.1",
    stripeJs: null,

    // Refactor done
    initStripe: function(params, callback)
    {
        if (typeof callback == "undefined")
            callback = null;

        var message = null;

        if (!this.stripeJs)
        {
            try
            {
                var options = {};
                if (params.options)
                {
                    options = params.options;
                }

                this.stripeJs = Stripe(params.apiKey, options);
            }
            catch (e)
            {
                if (typeof e != "undefined" && typeof e.message != "undefined")
                    message = 'Could not initialize Stripe.js: ' + e.message;
                else
                    message = 'Could not initialize Stripe.js';
            }

            if (this.stripeJs && typeof params.appInfo != "undefined")
            {
                try
                {
                    this.stripeJs.registerAppInfo(params.appInfo);
                }
                catch (e)
                {
                    console.warn(e);
                }
            }
        }

        if (callback)
            callback(message);
        else if (message)
            console.error(message);
    },

    // Refactor done
    handleCardPayment: function(paymentIntent, done)
    {
        try
        {
            this.stripeJs.handleCardPayment(paymentIntent.client_secret).then(function(result)
            {
                if (result.error)
                    return done(result.error.message);

                return done();
            });
        }
        catch (e)
        {
            done(e.message);
        }
    },

    // Refactor done
    handleCardAction: function(paymentIntent, done)
    {
        try
        {
            this.stripeJs.handleCardAction(paymentIntent.client_secret).then(function(result)
            {
                if (result.error)
                    return done(result.error.message);

                return done();
            });
        }
        catch (e)
        {
            done(e.message);
        }
    },

    // Refactor done
    authenticateCustomer: function(paymentIntentId, done)
    {
        try
        {
            var self = this;
            this.stripeJs.retrievePaymentIntent(paymentIntentId).then(function(result)
            {
                if (result.error)
                    return done(result.error);

                if (result.paymentIntent.status == "requires_action" ||
                    result.paymentIntent.status == "requires_source_action")
                {
                    if (result.paymentIntent.confirmation_method == "manual")
                        return self.handleCardAction(result.paymentIntent, done);
                    else
                        return self.handleCardPayment(result.paymentIntent, done);
                }

                return done();
            });
        }
        catch (e)
        {
            done(e.message);
        }
    }
};

var stripePaymentsExpressHyvaBridge = {
    // Define initial properties for the bridge
    shippingAddress: [],
    shippingMethod: null,
    elements: null,
    expressCheckoutElement: null,
    expressCheckoutOptions: null,
    clickResolvePayload: null,
    resolvePayload: null,
    pendingActionsQueue: [],
    isAddToCartPending: false,
    waitingForNewTotals: false,
    lastTotal: null,
    mountElementId: null,
    mode: null,
    loading: false,
    debug: false,
    alpineScope: null,

    isLoading() {
        return this.loading;
    },

    /**
     * Retrieve parameters for the express checkout element
     * @param payload
     * @param callback
     */
    getExpressCheckoutElementParams: function(payload, callback) {
        let self = this;
        let serviceUrl = self.bridgeBuildUrl('/rest/V1/stripe/payments/ece_params', {});

        this.storagePost(serviceUrl, JSON.stringify(payload), false)
            .then((response) => {
                self.processResponseWithECEParams(response, callback);
            })
            .catch((error) => {
                console.error("Could not retrieve initialization params for Express Checkout", error);
            });
    },

    /**
     * Process response received from Express Checkout Element Params API
     * @param response
     * @param callback
     */
    processResponseWithECEParams: function(response, callback) {
        try {
            if (typeof response === 'string') {
                response = JSON.parse(response);
            }

            if (response && response.resolvePayload) {
                if (response.resolvePayload.allowedShippingCountries) {
                    // Convert allowed shipping countries map to array
                    response.resolvePayload.allowedShippingCountries = Object.keys(response.resolvePayload.allowedShippingCountries).map(function (key) {
                        return response.resolvePayload.allowedShippingCountries[key];
                    });
                }

                callback(null, response);
            } else {
                callback(null, response);
            }
        } catch (e) {
            callback(e.message, response);
        }
    },

    /**
     * Initialize Stripe Express Checkout
     * @param elementId
     * @param stripeJsInitParams
     * @param locationDetails
     * @param expressCheckoutOptions
     * @param callback
     * @param alpineScope
     */
    initStripeExpress: function(elementId, stripeJsInitParams, locationDetails, expressCheckoutOptions, callback, alpineScope) {
        let self = this;

        // Pass alpine scope to control loader methods
        self.alpineScope = alpineScope;

        // Only initialize the express element if certain conditions are met
        if (locationDetails.location == 'minicart') {
            if (
                document.body.classList.contains('catalog-product-view') && 
                locationDetails.activeLocations.indexOf('product_page') >= 0) 
                {
                    return;
                }
            if (
                document.body.classList.contains('checkout-cart-index') && 
                locationDetails.activeLocations.indexOf('shopping_cart_page') >= 0
            ) {
                return;
            }
        }

        if (this.waitingForNewTotals) {
            // Prevent re-initialization if waiting for addToCart to finish
            return;
        }

        // Store initialization parameters
        self.mountElementId = elementId;
        self.stripeJsInitParams = stripeJsInitParams;
        self.locationDetails = locationDetails;
        self.expressCheckoutOptions = expressCheckoutOptions;

        // Fetch express checkout element parameters
        self.getExpressCheckoutElementParams(locationDetails, function(err, result) {
            if (err) {
                console.warn('Cannot initialize wallets: ' + err);
                return;
            }

            if (!result.elementOptions) return;

            self.mode = result.elementOptions.mode;
            self.clickResolvePayload = result.resolvePayload;

            // Initialize Stripe with the provided parameters
            stripe.initStripe(stripeJsInitParams, function(err) {
                if (err) {
                    self.showError(self.maskError(err));
                    return;
                }

                // Initialize elements and express checkout element
                self.initElements(result.elementOptions);
                self.initExpressCheckoutElement(elementId, expressCheckoutOptions, callback);
            });
        });
    },

    /**
     * Log messages if debugging is enabled
     */
    log: function() {
        if (this.debug) {
            console.log(...arguments);
        }
    },

    /**
     * Initialize Stripe Elements
     * @param elementsOptions
     */
    initElements: function(elementsOptions) {
        this.log('initElements', elementsOptions);
        if (!this.elements) {
            this.elements = stripe.stripeJs.elements(elementsOptions);
        } else {
            this.elements.update(elementsOptions);
        }
    },

    /**
     * Mask error messages related to API keys
     * @param err
     */
    maskError: function(err) {
        var errLowercase = err.toLowerCase();
        var pos1 = errLowercase.indexOf("Invalid API key provided".toLowerCase());
        var pos2 = errLowercase.indexOf("No API key provided".toLowerCase());
        if (pos1 === 0 || pos2 === 0) {
            return 'Invalid Stripe API key provided.';
        }

        return err;
    },

    /**
     * Initialize Express Checkout Element and mount it to DOM
     * @param elementId
     * @param expressCheckoutOptions
     * @param callback
     */
    initExpressCheckoutElement: function(elementId, expressCheckoutOptions, callback) {
        if (this.expressCheckoutElement) {
            return;
        }

        var DOMElement = document.querySelector(elementId),
            self = this;

        try {
            if (typeof expressCheckoutOptions === 'string') {
                expressCheckoutOptions = JSON.parse(expressCheckoutOptions);
            }

            // Create the express checkout element
            this.expressCheckoutElement = this.elements.create('expressCheckout', expressCheckoutOptions);
        } catch (e) {
            console.warn(e.message);
            return;
        }

        if (document.getElementById(elementId.substring(1))) {
            this.expressCheckoutElement.mount(elementId);
        }

        // Setup event listener for when the element is ready
        this.expressCheckoutElement.on('ready', function(result) {
            self.log("on.ready");
            if (result.availablePaymentMethods) {
                callback(self.expressCheckoutElement);
            } else {
                if (DOMElement) {
                    DOMElement.style.display = 'none';
                }
            }
        });
    },

    /**
     * Extract client secret from response if authentication is required
     * @param response
     */
    getClientSecretFromResponse: function(response) {
        if (typeof response != "string") {
            return null;
        }

        if (response.indexOf("Authentication Required: ") >= 0) {
            return response.substring("Authentication Required: ".length);
        }

        return null;
    },

    /**
     * Place an order using Stripe
     * @param result
     * @param location
     * @param callback
     */
    placeOrder: function(result, location, callback) {
        var serviceUrl = this.bridgeBuildUrl('/rest/V1/stripe/payments/place_order', {}),
            payload = {
                result: result,
                location: location
            },
            self = this;

        this.storagePost(serviceUrl, JSON.stringify(payload), false)
            .then((response) => {
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        return self.showError(response);
                    }
                }
                callback(null, response, result);
            })
            .catch((xhr) => {
                try {
                    var response = JSON.parse(xhr.message);
                    var clientSecret = self.getClientSecretFromResponse(response.message);

                    if (clientSecret) {
                        return stripe.authenticateCustomer(clientSecret, function(err) {
                            if (err) {
                                return callback(err, { message: err }, result);
                            }
                            self.placeOrder(result, location, callback);
                        });
                    } else {
                        callback(response.message, response, result);
                    }
                } catch (e) {
                    return self.showError(xhr.message);
                }
            });
    },

    /**
     * Add an item to the cart
     * @param params
     * @param shipping_id
     * @param callback
     */
    addToCart: function(params, shipping_id, callback) {
        let self = this;
        self.isAddToCartPending = true;
        self.waitingForNewTotals = true;
    
        var serviceUrl = self.bridgeBuildUrl('/rest/V1/stripe/payments/addtocart', {}),
            payload = { params: params, shipping_id: shipping_id };
    
        // Create a promise to handle the asynchronous operation
        var addToCartPromise = new Promise(function(resolve, reject) {
            self.storagePost(serviceUrl, JSON.stringify(payload), false)
                .then((response) => {
                    callback(null, response);
                    resolve(); // Resolve the promise after successful addition
                })
                .catch((xhr) => {
                    self.parseFailedResponse(xhr.message, callback);
                    reject(); // Reject the promise in case of an error
                });
        });
    
        // Once the promise resolves, handle the pending actions queue
        addToCartPromise.then(function() {
            self.isAddToCartPending = false;
    
            // Execute functions in the queue after promise resolution
            while (self.pendingActionsQueue.length) {
                var fn = self.pendingActionsQueue.shift();
                fn();
            }
    
            self.waitingForNewTotals = false;
    
            // Reload cart and messages to reflect updates, with a delay to ensure server processing is complete
            setTimeout(function() {
                // customerData.reload(['cart', 'messages'], true);
            }, 1000);
        }).catch(function() {
            // Handle any additional cleanup or logging in case of rejection
            console.log('Failed to add item to cart. Handling rejection.');
        });
    
        return addToCartPromise;
    },

    /**
     * Extract shipping address from ECE shipping address
     * @param eceShippingAddress
     */
    getShippingAddressFrom: function(eceShippingAddress) {
        if (!eceShippingAddress) {
            return null;
        }

        // For some countries like Japan, the ECE does not set the City, only the region
        if (eceShippingAddress.city.length == 0 && eceShippingAddress.region.length > 0) {
            eceShippingAddress.city = eceShippingAddress.region;
        }

        return eceShippingAddress;
    },

    /**
     * Fetch new shipping rates for a given address
     * @param address
     * @param callback
     */
    getNewShippingRatesFor: function(address, callback) {
        let self = this;
        var serviceUrl = self.bridgeBuildUrl('/rest/V1/stripe/payments/ece_shipping_address_changed', {}),
            payload = { newAddress: address, location: this.locationDetails.location };

        this.storagePost(serviceUrl, JSON.stringify(payload), false)
            .then((response) => {
                self.processResponseWithECEParams(response, callback);
            })
            .catch((xhr) => {
                self.parseFailedResponse(xhr.message, callback);
            });
    },

    /**
     * Parse failed response and invoke callback with an error message
     * @param responseText
     * @param callback
     */
    parseFailedResponse: function(responseText, callback) {
        try {
            let response = JSON.parse(responseText);
            callback(response.message);
        } catch (e) {
            callback(responseText);
        }
    },

    /**
     * Update the shipping rate and return new totals
     * @param address
     * @param shipping_id
     * @param callback
     */
    updateShippingRate: function(address, shipping_id, callback) {
        let self = this;
        var serviceUrl = self.bridgeBuildUrl('/rest/V1/stripe/payments/ece_shipping_rate_changed', {}),
            payload = { address: address, shipping_id: shipping_id };

        this.storagePost(serviceUrl, JSON.stringify(payload), false)
            .then((response) => {
                self.processResponseWithECEParams(response, callback);
            })
            .catch((xhr) => {
                self.parseFailedResponse(xhr.message, callback);
            });
    },

    /**
     * Handle shipping address change event
     * @param event
     */
    onShippingAddressChange: function(event) {
        let self = this;
        self.log("onShippingAddressChange");
        var executeMethod = this.onShippingAddressChangeAction.bind(self, event);

        if (self.isAddToCartPending) {
            self.pendingActionsQueue.push(executeMethod);
        } else {
            executeMethod();
        }
    },

    /**
     * Action to perform when shipping address changes
     * @param event
     */
    onShippingAddressChangeAction: function(event) {
        let self = this;
        self.shippingAddress = self.getShippingAddressFrom(event.address);
        self.waitingForNewTotals = true;
        self.getNewShippingRatesFor(self.shippingAddress, function(err, eceResponseParams) {
            if (err) {
                event.reject();
                self.waitingForNewTotals = false;
                return self.showError(err);
            }

            if (!eceResponseParams.resolvePayload.shippingRates) {
                event.reject();
                self.waitingForNewTotals = false;
                return;
            }

            self.resolveEvent(event, eceResponseParams.resolvePayload);
            self.waitingForNewTotals = false;
        });
    },

    /**
     * Resolve an event with the given payload
     * @param event
     * @param resolvePayload
     */
    resolveEvent: function(event, resolvePayload) {
        if (!event) {
            return;
        }

        let self = this;
        var total = this.getLineItemsTotal(resolvePayload.lineItems);

        if (resolvePayload.lineItems && !event.isClick && self.mode != "setup") {
            if (total > 0) {
                self.log('Updating total to ' + total + ' cents & resolving event with delay', resolvePayload, total);
                var promise = self.elements.update({amount: total});
            } else {
                self.log('Will not update total to 0 cents', resolvePayload, total);
                delete resolvePayload.lineItems;
            }

            // Delay event resolution to ensure processing is complete
            setTimeout(function() {
                event.resolve(resolvePayload);
            }, 1000);
        } else {
            if (self.mode == "setup" && resolvePayload.lineItems) {
                delete resolvePayload.lineItems;
            }
            self.log('Resolving event with no delay ', resolvePayload, self.isAddToCartPending, total);
            event.resolve(resolvePayload);
        }
    },

    /**
     * Calculate total amount from line items
     * @param lineItems
     */
    getLineItemsTotal: function(lineItems) {
        var total = 0;

        if (!lineItems || !lineItems.length) {
            return total;
        }

        for (var i = 0; i < lineItems.length; i++) {
            total += lineItems[i].amount;
        }

        return total;
    },

    /**
     * Handle shipping rate change event
     * @param event
     */
    onShippingRateChange: function(event) {
        this.log("onShippingRateChange");
        var executeMethod = this.onShippingRateChangeAction.bind(this, event);

        if (this.isAddToCartPending) {
            this.pendingActionsQueue.push(executeMethod);
        } else {
            executeMethod();
        }
    },

    /**
     * Action to perform when shipping rate changes
     * @param event
     */
    onShippingRateChangeAction: function(event) {
        let self = this;
        var shippingMethod = event.shippingRate.hasOwnProperty('id') ? event.shippingRate.id : null;
        this.waitingForNewTotals = true;
        this.updateShippingRate(this.shippingAddress, shippingMethod, function(err, response) {
            if (err) {
                event.reject();
                self.waitingForNewTotals = false;
                return self.showError(err);
            }

            self.resolveEvent(event, response.resolvePayload);
            self.waitingForNewTotals = false;
        });
    },

    /**
     * Start loading indicator
     */
    startLoader: function() {
        let self = this;
        if (self.alpineScope.loading) {
            return;
        }
        self.alpineScope.loading = true;
    },

    /**
     * Stop loading indicator
     */
    stopLoader: function() {
        let self = this;
        if (!self.alpineScope.loading) {
            return;
        }
        self.alpineScope.loading = false;
    },

    /**
     * Confirm the payment method and place order
     * @param location
     * @param confirmResult
     */
    onConfirm: function(location, confirmResult) {
        this.startLoader();

        var onPaymentMethodCreated = this.onPaymentMethodCreated.bind(this, confirmResult, location);
        var showError = this.showError.bind(this);

        var paymentMethodData = {
            elements: this.elements,
            params: {
                billing_details: confirmResult.billingDetails
            },
            shipping: confirmResult.shippingAddress
        };

        this.elements.submit().then(function() {
            stripe.stripeJs.createConfirmationToken(paymentMethodData).then(function(createConfirmationTokenResult) {
                if (createConfirmationTokenResult.error) {
                    return showError(createConfirmationTokenResult.error.message);
                } else if (createConfirmationTokenResult.confirmationToken) {
                    confirmResult.confirmationToken = createConfirmationTokenResult.confirmationToken;
                    return onPaymentMethodCreated();
                } else {
                    this.stopLoader();
                    throw new Error('Invalid response from Stripe');
                }
            }).catch(function(error) {
                return showError(error.message);
            });
        }).catch(function(error) {
            return showError(error.message);
        });
    },

    /**
     * Handle cancel action
     */
    onCancel: function() {
        this.log("onCancel");
        this.stopLoader();
    },

    /**
     * Initialize checkout widget with validation
     * @param checkoutValidator
     */
    initCheckoutWidget: function(checkoutValidator) {
        let self = this;
        this.expressCheckoutElement.on('click', function(event) {
            if (!checkoutValidator()) {
                //event.preventDefault();
                return;
            }

            event.isClick = true;
            self.startLoader();
            self.resolveEvent(event, self.clickResolvePayload);
        });
        this.expressCheckoutElement.on('shippingaddresschange', this.onShippingAddressChange.bind(this));
        this.expressCheckoutElement.on('shippingratechange', this.onShippingRateChange.bind(this));
        this.expressCheckoutElement.on('confirm', this.onConfirm.bind(this, 'checkout'));
        this.expressCheckoutElement.on('cancel', this.onCancel.bind(this));
    },

    /**
     * Initialize widget for the cart page
     */
    initCartWidget: function() {
        let self = this;
        this.expressCheckoutElement.on('click', function(event) {
            event.isClick = true;
            self.startLoader();
            self.resolveEvent(event, self.clickResolvePayload);
        });
        this.expressCheckoutElement.on('shippingaddresschange', this.onShippingAddressChange.bind(this));
        this.expressCheckoutElement.on('shippingratechange', this.onShippingRateChange.bind(this));
        this.expressCheckoutElement.on('confirm', this.onConfirm.bind(this, 'cart'));
        this.expressCheckoutElement.on('cancel', this.onCancel.bind(this));
    },

    /**
     * Initialize widget for the mini cart
     */
    initMiniCartWidget: function() {
        let self = this;
        this.expressCheckoutElement.on('click', function(event) {
            event.isClick = true;
            self.startLoader();
            self.resolveEvent(event, self.clickResolvePayload);
        });
        this.expressCheckoutElement.on('shippingaddresschange', this.onShippingAddressChange.bind(this));
        this.expressCheckoutElement.on('shippingratechange', this.onShippingRateChange.bind(this));
        this.expressCheckoutElement.on('confirm', this.onConfirm.bind(this, 'minicart'));
        this.expressCheckoutElement.on('cancel', this.onCancel.bind(this));
    },

    /**
     * Initialize widget for a single product page
     */
    initProductWidget: function() {
        let self = this;
        this.expressCheckoutElement.on('click', function(event) {
            event.isClick = true;
            return self.onClickAtProductPage(event);
        });
        this.expressCheckoutElement.on('shippingaddresschange', this.onShippingAddressChange.bind(this));
        this.expressCheckoutElement.on('shippingratechange', this.onShippingRateChange.bind(this));
        this.expressCheckoutElement.on('confirm', this.onConfirm.bind(this, 'product'));
        this.expressCheckoutElement.on('cancel', this.onCancel.bind(this));

        // Bind configurable product options
        this.bindConfigurableProductOptions();
    },

    /**
     * Convert form data into an object
     * @param form
     */
    formToArrayObject: function(form) {
        if (!form) {
            return {};
        }

        // Create a FormData object from the form
        const formData = new FormData(form);
        const obj = {};

        // Convert FormData entries to an object
        formData.forEach((value, key) => {
            if (obj[key] !== undefined) {
                if (!Array.isArray(obj[key])) {
                    obj[key] = [obj[key]];
                }
                obj[key].push(value);
            } else {
                obj[key] = value;
            }
        });

        return obj;
    },

    /**
     * Handle click event on the product page
     * @param event
     */
    onClickAtProductPage: function(event) {
        this.log("onClickAtProductPage");
        let self = this,
            form = document.querySelector('#product_addtocart_form'),
            params = [];

        let bridgeIsProductAddToCartFormValidResult = self.bridgeIsProductAddToCartFormValid(form);

        if (!bridgeIsProductAddToCartFormValidResult) {
            return false;
        }
        self.startLoader();
        // Add to Cart
        params = this.formToArrayObject(form);
        this.addToCart(params, this.shippingMethod, function(err) {
            if (err) {
                self.showError(err);
                return false;
            }
        });

        this.resolveEvent(event, this.clickResolvePayload);
        return true;
    },

    /**
     * Display error message
     * @param message
     */
    showError: function(message) {
        let self = this;
        window.dispatchMessages([
            {
                type: "error",
                text: message
            }
        ], 3000);

        self.stopLoader();
    },

    /**
     * Handle creation of payment method and place order
     * @param result
     * @param location
     */
    onPaymentMethodCreated: function(result, location) {
        let self = this;
        this.placeOrder(result, location, function(err, response, result) {
            if (err) {
                self.showError(response.message);
            } else if (response.hasOwnProperty('redirect')) {
                // Redirect to the specified location
                window.location = response.redirect;
            } else {
                self.stopLoader();
            }
        });
    },

    /**
     * Bind events to configurable product options
     */
    bindConfigurableProductOptions: function() {
        let self = this;
        var options = document.querySelectorAll("#product-options-wrapper .configurable select.super-attribute-select");

        options.forEach(function(select) {
            var onConfigurableProductChanged = self.onConfigurableProductChanged.bind(self, select);
            select.addEventListener("change", onConfigurableProductChanged);
        });
    },

    /**
     * Handle change event for configurable product options
     * @param element
     */
    onConfigurableProductChanged: function(element) {
        let self = this;

        if (element.value) {
            var locationDetails = {
                location: 'product',
                productId: this.locationDetails.productId,
                attribute: element.value
            };
            this.initStripeExpress(
                this.mountElementId,
                this.stripeJsInitParams,
                locationDetails,
                self.expressCheckoutOptions,
                self.initProductWidget.bind(self)
            );
        }
    },

    /**
     * Validate the product add to cart form
     * @param form
     */
    bridgeIsProductAddToCartFormValid: function(form) {
        if (form.checkValidity()) {
            return true;
        } else {
            form.reportValidity();
        }
        return false;
    },

    /**
     * Serialize the product add to cart form into an object
     * @param form
     */
    bridgeSerializeProductAddToCartForm: function(form) {
        if (form) {
            // Get all field data from the form
            let data = new FormData(form);
            let obj = {};
            for (let [key, value] of data) {
                if (obj[key] !== undefined) {
                    if (!Array.isArray(obj[key])) {
                        obj[key] = [obj[key]];
                    }
                    obj[key].push(value);
                } else {
                    obj[key] = value;
                }
            }
            return obj;
        }
        return {};
    },

    /**
     * Build the complete URL for API calls
     * @param path
     */
    bridgeBuildUrl: function(path) {
        if (path.indexOf(BASE_URL) !== -1) {
            return path;
        } else {
            return BASE_URL + path;
        }
    },

    /**
     * Perform a POST request to the given URL
     * @param url
     * @param data
     * @param global
     * @param contentType
     * @param headers
     */
    storagePost: function(url, data, global, contentType, headers) {
        headers = headers || {};
        global = global === undefined ? true : global;
        contentType = contentType || 'application/json';

        return fetch(this.bridgeBuildUrl(url), {
            method: 'POST',
            headers: {
                'Content-Type': contentType,
                ...headers
            },
            body: data
        }).then(response => {
            if (!response.ok) {
                return response.text().then(text => Promise.reject(new Error(text)));
            } else {
                return response.json();
            }
        });
    }
}
