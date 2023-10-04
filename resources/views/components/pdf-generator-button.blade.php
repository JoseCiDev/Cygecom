<button id="print-pdf" data-cy="print-pdf" class="btn btn-primary btn-large">Imprimir PDF</button>

<script>
    $(()=> {
        const element = $('{{ $selector }}');

        const createPdf = () => {
            element.css('margin', '0 auto')

            const elements = element.find('*');
            for (let i = 0; i < elements.length; i++) {
                elements[i].style.fontSize = '10px';
                elements[i].style.padding = '0';
                elements[i].style.margin = '0';
            }

            element.find('.box-title .request-title')
                .css({
                    'font-size': '10px',
                    'font-weight': '400',
                    'line-height': '9px',
                    'text-align': 'center',
                    'letter-spacing': '7px',
                    'padding': '10px',
                    'margin': '3px auto',
                    'color': '#333',
                    'text-transform': 'uppercase',
                });

            element.find('.box-title').css('margin', '3px 0')

            element.find('.request-details-content').css('margin', '1px 0')

            element.find('.text-highlight')
                .add(element.find('.text-highlight strong'))
                .css('font-size', '12px')

            element.find('.cost-center-box p')
                .add(element.find('.request-details-content p'))
                .css('line-height', '15px')

            const body = document.querySelector('body');
            body.innerHTML = element[0].outerHTML

            window.print();
            window.location.reload()
        }

        $('#print-pdf').on('click', createPdf);
    })
</script>


