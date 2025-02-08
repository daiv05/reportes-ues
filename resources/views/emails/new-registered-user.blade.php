<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header
            title="{{ 'Registro en plataforma ' . ' ' . config('app.name') }}"
            logoSrc="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s" />
        <p>
            Has sido registrado en la plataforma <strong>{{ config('app.name') }}</strong>.
        </p>
        <p>
            Tus credenciales de acceso son:
        </p>
        <p>
            <strong>Usuario:</strong>
            <strong>{{ $username }}</strong>
        </p>
        <p>
            <strong>Contraseña:</strong>
            <strong>{{ $password }}</strong>
        </p>
    </x-emails.email-body>

    <x-emails.email-footer :footerLinks="[
        ['label' => 'Página oficial', 'url' => 'https://www.ues.edu.sv'],
        ['label' => 'Contacto', 'url' => 'https://www.ues.edu.sv/contacto/'],
        ['label' => 'Noticias', 'url' => 'https://www.ues.edu.sv/noticias/'],
    ]" />
</x-emails.email-container>

