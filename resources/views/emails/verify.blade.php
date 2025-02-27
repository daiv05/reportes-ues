<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header
            title="Verificación de correo"
            logoSrc="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s" />
        <p>
            Gracias por registrarte.
            Tu código de verificación es:
            <strong>{{ $code }}</strong>
        </p>
        <p>
            Si no haz solicitado ningún código puedes ignorar este correo.
        </p>
    </x-emails.email-body>

    <x-emails.email-footer :footerLinks="[
        ['label' => 'FIA', 'url' => 'https://www.fia.ues.edu.sv/'],
        ['label' => 'EISI', 'url' => 'https://eisi.fia.ues.edu.sv/'],
        ['label' => 'UES', 'url' => 'https://www.ues.edu.sv/'],
    ]" />
</x-emails.email-container>

