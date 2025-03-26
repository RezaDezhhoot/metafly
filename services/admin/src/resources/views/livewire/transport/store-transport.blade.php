@use('App\Enums\PageAction')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.transport')]).(' '.$header ?? '') )

    <x-admin.form-control cancel="{{ route('transport.index') }}" deleteAble="{{$mode === PageAction::UPDATE}}"  title="{{__('general.sidebar.transport')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input width="4" type="title" :required="true" id="city" label="{{__('general.title')}}" wire:model.defer="title"/>
                <x-admin.forms.dropdown width="4" id="type" :required="true" :data="$data['type']" label="{{__('general.type')}}" wire:model.defer="type"/>
                <x-admin.forms.dropdown width="4" id="status" :required="true" :data="$data['status']" label="{{__('general.status')}}" wire:model.defer="status"/>
                <x-admin.forms.lfm-standalone id="logo" :required="true" label="{{__('general.logo')}}" :file="$logo"  wire:model.defer="logo"/>
            </x-admin.form-section>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem() {
            Swal.fire({
                title: '{{ __('general.actions.delete_item') }}',
                text: '{{ __('general.messages.delete_item') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ __('general.actions.no') }}',
                confirmButtonText: '{{ __('general.actions.yes') }}',
            }).then((result) => {
                if (result.value) {
                    @this.call('deleteItem')
                }
            })
        }
    </script>
@endpush
