<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header title="Código de verificación" />
        <p>
            Hemos detectado que has iniciado sesión desde un dispositivo desconocido.
            Para continuar, ingresa el siguiente código de verificación:
            <strong>{{ $token }}</strong>
        </p>
        <p>
            Si no haz solicitado ningún código puedes ignorar este correo.
        </p>
    </x-emails.email-body>

    <x-emails.email-footer />
</x-emails.email-container>
