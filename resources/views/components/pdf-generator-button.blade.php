<button id="print-pdf" data-cy="print-pdf" class="btn btn-primary btn-large">Imprimir PDF</button>

<script>
    $(()=> {
        $('#print-pdf').on('click', function() {
            const element = $('{{ $selector }}');

            const elements = element.find('*');
            for (let i = 0; i < elements.length; i++) {
                elements[i].style.fontSize = '10px';
                elements[i].style.padding = '0';
                elements[i].style.margin = '0';
            }

            const detailsTitle = element.find('.box-title .request-title');
            detailsTitle.css({
                'font-size': '10px',
                'font-weight': '400',
                'line-height': '9px',
                'text-align': 'center',
                'letter-spacing': '7px',
                'max-width': '840px',
                'margin': '3px 0',
                'color': '#333',
                'text-transform': 'uppercase',
            });

            const boxTitle = element.find('.box-title');
            boxTitle.css({
                'margin': '3px 0',
            });

            const requestDetailsContent = element.find('.request-details-content');
            requestDetailsContent.css({
                'margin': '1px 0',
            });

            const textToHighlight = element.find('.text-highlight');
            textToHighlight.css({
                'font-size': '12px',
            });

            const subTextToHighlight = element.find('.text-highlight strong');
            subTextToHighlight.css({
                'font-size': '12px',
            });

            const opt = {
                margin : 4,
                filename: '{{$fileName}}' + '.pdf',
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'letter', orientation: 'portrait' },
            };

            html2pdf().from(element[0]).set(opt).save().then(() => location.reload());
        });
    })
</script>


