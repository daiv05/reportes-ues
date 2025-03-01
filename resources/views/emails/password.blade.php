<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header
            title="Reestablecer Contraseña" />
        <p>
            Estás a punto de reestablecer la contraseña de tu cuenta.
            Tu código de verificación es:
            <strong>{{ $code }}</strong>
        </p>
        <p>
            Si no haz solicitado ningún código puedes ignorar este correo.
        </p>
    </x-emails.email-body>

    <x-emails.email-footer />
</x-emails.email-container>
