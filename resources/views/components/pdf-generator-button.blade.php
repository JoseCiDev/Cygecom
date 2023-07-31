<button id="print-pdf" data-cy="print-pdf" class="btn btn-primary">Imprimir PDF</button>

<script>
    $(()=> {
        $('#print-pdf').on('click', function() {
            const element = $('{{ $selector }}');

            const elements = element.find('*');
            for (let i = 0; i < elements.length; i++) {
                elements[i].style.fontSize = '12px';
            }

            const opt = {
                margin : 1,
                filename: '{{$fileName}}' + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { avoid: ".no-pagebreak", mode: "css", before: ".pagebreak" },
            };

            html2pdf().from(element[0]).set(opt).save().then(() => location.reload());
        });
    })
</script>


