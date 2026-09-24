<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('Veuillez saisir le code de sécurité généré par votre application d\'authentification.') }}
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div>
            <x-input-label for="code" :value="__('Code de vérification')" />

            <x-text-input
                id="code"
                class="block mt-1 w-full"
                type="text"
                name="code"
                inputmode="numeric"
                autocomplete="one-time-code"
                autofocus
            />

            <x-input-error
                :messages="$errors->get('code')"
                class="mt-2"
            />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Vérifier') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-4 text-sm text-gray-600">
        Si vous avez perdu accès à votre application d'authentification,
        vous pouvez utiliser un code de récupération.
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}" class="mt-3">
        @csrf

        <div>
            <x-input-label
                for="recovery_code"
                :value="__('Code de récupération')"
            />

            <x-text-input
                id="recovery_code"
                class="block mt-1 w-full"
                type="text"
                name="recovery_code"
                autocomplete="off"
            />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Utiliser le code de récupération') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>