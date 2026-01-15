document.addEventListener('DOMContentLoaded', async() => {
    try {

        //funzione filtraggio categorie
        const boxFilter = document.querySelectorAll('.filter-option');
        boxFilter.forEach(element => {
            const titolo = element.querySelector('.titolo-sottocategoria').textContent.replace(/^\s+|\s+$/g, '').replace(/\s+/g, ' ');

            if (titolo === 'Categoria') {

                const categorie = element.querySelectorAll('.sottocategoria');
                categorie.forEach(elem => {
                    const nome = elem.querySelector('.label-sottocategoria').textContent;
                    const slug = nome.toLowerCase().replace(/[\s\W-]+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '');
        
                    elem.href = window.location.href + '/' + slug;
                });
            }
        });

        //funzione valore 0 quantità
        const input = document.querySelector('.quantità-prodotto');
        let quantità = input.value

        if (quantità === '0') {
            quantità = '1'
            input.value = quantità
            
        }

    } catch (error) {

    }
});