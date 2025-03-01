<x-emails.email-container>
    <x-emails.email-body>
        <x-emails.email-header title="Reestablecer Contraseña" />
        <p>
            Está recibiendo este correo electrónico porque hemos recibido una solicitud de restablecimiento de
            contraseña para su cuenta.
        </p>
        <div class="flex-div">
            <a class="btn-primary" href="{{ $token }}">Restablecer</a>
        </div>
        <p>
            Si no haz solicitado ningún reestablecimiento puedes ignorar este correo.
        </p>
    </x-emails.email-body>

    <x-emails.email-footer />
</x-emails.email-container>
