<button id="print-pdf" data-cy="print-pdf" class="btn btn-primary">Imprimir PDF</button>

<script>
    $(()=> {
        $('#print-pdf').on('click', function() {
            const element = $('{{ $selector }}');

            const elements = element.find('*');
            for (let i = 0; i < elements.length; i++) {
                elements[i].style.fontSize = '12px';
            }

            const paragraphs = element.find('p');
            paragraphs.css({
                'margin': '0',
                'font-size': '12px',
            });

            const tabContent = element.find('.tab-content');
            tabContent.css({
                'padding': '0',
            });

            const requestDetailsContentBox = element.find('.request-details-content-box');
            requestDetailsContentBox.css({
                'padding': '5px',
            });

            const opt = {
                margin : 1,
                filename: '{{$fileName}}' + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'letter', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };

            html2pdf().from(element[0]).set(opt).save().then(() => location.reload());
        });
    })
</script>


