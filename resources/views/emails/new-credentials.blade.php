<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header
            title="{{ $title }}"
            logoSrc="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s" />
        <p>
            Tus nuevas credenciales de acceso a <a href=" {{ config('app.url') }}"> {{ config('app.name') }}</a> son:
        </p>
        <p>
            <strong>Usuario:</strong>
            <strong>{{ $username }}</strong>
        </p>
        <p>
            <strong>Contraseña:</strong>
            <strong>{{ $tempPass }}</strong>
        </p>
        <p>
            Recomendaos cambiar tu contraseña en tu primer inicio de sesión.
        </p>
        <p>
            <strong>Nota:</strong>
            <strong>Este correo es generado automáticamente, por favor no responder a este mensaje.</strong>
        </p>
    </x-emails.email-body>

    <x-emails.email-footer :footerLinks="[
        ['label' => 'Página oficial', 'url' => 'https://www.ues.edu.sv'],
        ['label' => 'Contacto', 'url' => 'https://www.ues.edu.sv/contacto/'],
        ['label' => 'Noticias', 'url' => 'https://www.ues.edu.sv/noticias/'],
    ]" />
</x-emails.email-container>

