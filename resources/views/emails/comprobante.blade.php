<!DOCTYPE html>
<html>
<head>
    <title>Resultados del Procesamiento de Comprobantes</title>
</head>
<body>
    <h1>Estimado {{ $user->name }},</h1>
    <p>A continuación, se detallan los comprobantes procesados:</p>

    <h2>Comprobantes Subidos Correctamente</h2>
    @if(count($successfulVouchers) > 0)
        <ul>
            @foreach ($successfulVouchers as $comprobante)
            <li>
                <ul>
                    <li>Nombre del Emisor: {{ $comprobante->issuer_name }}</li>
                    <li>Tipo de Documento del Emisor: {{ $comprobante->issuer_document_type }}</li>
                    <li>Número de Documento del Emisor: {{ $comprobante->issuer_document_number }}</li>
                    <li>Nombre del Receptor: {{ $comprobante->receiver_name }}</li>
                    <li>Tipo de Documento del Receptor: {{ $comprobante->receiver_document_type }}</li>
                    <li>Número de Documento del Receptor: {{ $comprobante->receiver_document_number }}</li>
                    <li>Monto Total: {{ $comprobante->total_amount }} {{ $comprobante->currency_code }}</li>
                    <li>Identificador de Factura: {{ $comprobante->document_serie }}-{{ $comprobante->document_number }}</li>
                    <li>Tipo de Comprobante: {{ $comprobante->document_type_code }}</li>
                    <li>Moneda: {{ $comprobante->currency_code }}</li>
                </ul>
            </li>
            @endforeach
        </ul>
    @else
        <p>No se subieron comprobantes correctamente.</p>
    @endif

    <h2>Comprobantes Fallidos</h2>
    @if(count($failedVouchers) > 0)
        <ul>
            @foreach ($failedVouchers as $comprobante)
            <li>
                Contenido: {{ $comprobante['xml_content'] }}<br>
                Motivo: {{ $comprobante['reason'] }}
            </li>
            @endforeach
        </ul>
    @else
        <p>No hubo comprobantes fallidos.</p>
    @endif

    <p>Gracias por usar nuestro servicio.</p>
</body>
</html>
