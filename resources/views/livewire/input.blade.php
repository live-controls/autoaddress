<div>

    @once
        @push('scripts')
            @if($backend == "cepaberto")
                <script src="https://unpkg.com/imask"></script>
                <script type="text/javascript">
                    window.{{ $prefix.$areacodeName }}mask = IMask(
                        document.getElementById('{{ $prefix.$areacodeName }}'),
                        {
                            mask: '00000-000'
                        }
                    );

                    document.addEventListener("DOMContentLoaded", () => {
                        @if(!is_null($areacode))
                            window.{{ $prefix.$areacodeName }}mask.value = "{{ $areacode }}";
                        @endif
                    });

                    Livewire.on('{{ $prefix.$areacodeName }}-valueUpdated', value => {
                        @this.cep = window.{{ $prefix.$areacodeName }}mask.unmaskedValue;
                        Livewire.emit('areacodeUpdated');
                    });
                </script>
            @endif
        @endpush
    @endonce

    <!-- AUTOADDRESS CONTENT -->
    <div class="form-control w-1/2">
        <label for="{{ $prefix.$areacodeName }}" class="label">
            <span class="label-text">
                {{ __('livecontrols-autoaddress::autoaddress.areacode') }}
                @if($titlesuffix != '') {{ $titlesuffix }} @endif
            </span>
        </label>
        <input
            id="{{ $prefix.$areacodeName }}"
            name="{{ $prefix.$areacodeName }}"
            type="text"
            class="input input-bordered w-full"
            wire:model.debounce.250ms='areaCodeValue'
            value="{{ is_null($oldmodel) ? old($prefix.$areacodeName) : old($prefix.$areacodeName, $oldmodel->{$prefix.$areacodeName}) }}"
            @if($required) required @endif
        />
        <x-input-error for="{{ $prefix.$areacodeName }}"></x-input-error>
        <p wire:loading wire:target='fetchInfos'>
            {{ __('livecontrols-autoaddress::autoaddress.searching') }}
        </p>
        @if($valid == 0)
            <span class="text-error" wire:loading.remove>
                {{ __('livecontrols-autoaddress::autoaddress.invalid_areacode') }}
            </span>
        @endif
    </div>

    <div class="grid grid-cols-3 gap-2">
        <div class="form-control w-auto col-span-2">
            <label for="{{ $prefix.$streetName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autoaddress::autoaddress.street') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$streetName }}"
                name="{{ $prefix.$streetName }}"
                type="text"
                class="input input-bordered w-full"
                wire:model='street'
                value="{{ is_null($oldmodel) ? old($prefix.$streetName) : old($prefix.$streetName, $oldmodel->{$prefix.$streetName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$streetName }}"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix.$numberName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autoaddress::autoaddress.number') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$numberName }}"
                name="{{ $prefix.$numberName }}"
                type="text"
                class="input input-bordered w-full"
                value="{{ is_null($oldmodel) ? old($prefix.$numberName) : old($prefix.$numberName, $oldmodel->{$prefix.$numberName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$numberName }}"></x-input-error>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-2">
        <div class="form-control w-auto">
            <label for="{{ $prefix.$complementName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autoaddress::autoaddress.complement') }}
                </span>
            </label>
            <input
                id="{{ $prefix.$complementName }}"
                name="{{ $prefix.$complementName }}"
                type="text"
                class="input input-bordered w-full"
                value="{{ is_null($oldmodel) ? old($prefix.$complementName) : old($prefix.$complementName, $oldmodel->{$prefix.$complementName}) }}"
            />
            <x-input-error for="{{ $prefix.$complementName }}"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix.$areaName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autoaddress::autoaddress.area') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$areaName }}"
                name="{{ $prefix.$areaName }}"
                type="text"
                class="input input-bordered w-full"
                wire:model='area'
                value="{{ is_null($oldmodel) ? old($prefix.$areaName) : old($prefix.$areaName, $oldmodel->{$prefix.$areaName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$areaName }}"></x-input-error>
        </div>
    </div>

    <div class="grid grid-cols-5 gap-2">
        <div class="form-control w-auto col-span-4">
            <label for="{{ $prefix.$cityName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autoaddress::autoaddress.city') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$cityName }}"
                name="{{ $prefix.$cityName }}"
                type="text"
                class="input input-bordered w-full"
                wire:model='city'
                value="{{ is_null($oldmodel) ? old($prefix.$cityName) : old($prefix.$cityName, $oldmodel->{$prefix.$cityName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$cityName }}"></x-input-error>
        </div>
        <div class="form-control w-auto">
            <label for="{{ $prefix.$stateName }}" class="label">
                <span class="label-text">
                    {{ __('livecontrols-autoaddress::autoaddress.state') }}
                    @if($titlesuffix != '') {{ $titlesuffix }} @endif
                </span>
            </label>
            <input
                id="{{ $prefix.$stateName }}"
                name="{{ $prefix.$stateName }}"
                type="text"
                @if($backend == "cepaberto")
                    maxlength="2"
                @endif
                class="input input-bordered w-full"
                wire:model='state'
                value="{{ is_null($oldmodel) ? old($prefix.$stateName) : old($prefix.$stateName, $oldmodel->{$prefix.$stateName}) }}"
                @if($required) required @endif
            />
            <x-input-error for="{{ $prefix.$stateName }}"></x-input-error>
        </div>
    </div>

    @if($backend == "cepaberto")
        <input type="hidden" name="{{ $prefix.$countryName }}" wire:model='country'>
    @else
        <!-- TODO: Add a select for the country or something. -->
    @endif

    <!-- /AUTOADDRESS CONTENT -->

</div>