import process from "./tailwindProcess";

(() => {

    window.addEventListener('message', (event) => {
        if (event.data && event.data.id === 'tailwindcss-jit-process') {
            const message = event.data.details;

            process(message.htmlContent, message.customConfig, message.customCss)
                .then((resultCss) => {
                    window.parent.postMessage({
                        id: 'tailwindcss-jit-result',
                        requestNum: event.data.requestNum,
                        css: resultCss,
                    }, window.location.protocol + '//' + window.location.host);
                });
        }
    });

    window.tailwindCSS = {process};

})()
