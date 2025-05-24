<div class="flex flex-col gap-y-6">
    @if ($messageBag->isNotEmpty())
        @foreach($messageBag->all() as $value)
            <p class="fi-fo-field-wrp-error-message text-danger-600 dark:text-danger-400">{{ __($value) }}</p>
        @endforeach
    @endif

    @if (count($visibleProviders))
        @if($showDivider)
            <div class="relative flex items-center justify-center text-center">
                <div class="absolute border-t border-gray-200 w-full h-px"></div>
                <p class="inline-block relative bg-white text-sm p-2 rounded-full font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-100">
                    {{ __('filament-socialite::auth.login-via') }}
                </p>
            </div>
        @endif

        <div class="grid @if(count($visibleProviders) > 1) grid-cols-2 @endif gap-4">
            @foreach($visibleProviders as $key => $provider)
                @if($key === 'github')
                    <x-filament::button
                        :color="$provider->getColor()"
                        :outlined="$provider->getOutlined()"
                        tag="a"
                        :href="route($socialiteRoute, $key)"
                        :spa-mode="false"
                    >
                        <x-slot name="icon">
                            <svg class="h-5 w-5 text-white" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="fill: currentColor;">
                                <title>GitHub</title>
                                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12" style="fill: #ffffff !important;"/>
                            </svg>
                        </x-slot>
                        {{ $provider->getLabel() }}
                    </x-filament::button>
                @else
                    <x-filament::button
                        :color="$provider->getColor()"
                        :outlined="$provider->getOutlined()"
                        :icon="$provider->getIcon()"
                        tag="a"
                        :href="route($socialiteRoute, $key)"
                        :spa-mode="false"
                    >
                        {{ $provider->getLabel() }}
                    </x-filament::button>
                @endif
            @endforeach
        </div>
    @else
        <span></span>
    @endif
</div>
