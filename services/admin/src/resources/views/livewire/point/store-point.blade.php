@use('App\Enums\PageAction')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.point')]).(' '.$header ?? '') )

    <x-admin.form-control cancel="{{ route('point.index') }}" deleteAble="{{$mode === PageAction::UPDATE}}"  title="{{__('general.sidebar.point')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input width="6" type="text" :required="true" id="city" label="{{__('general.city')}}" wire:model.defer="city"/>
                <x-admin.forms.select2-local  width="6" :required="true" id="country" :current="$country" :data="$data['country']" label="{{__('general.country')}}" wire:model.defer="country" />
                <x-admin.forms.lfm-standalone id="image" :required="true" label="{{__('general.image')}}" :file="$image"  wire:model.defer="image"/>
            </x-admin.form-section>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function deleteItem(id) {
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
                @this.call('deleteItem', id)
                }
            })
        }
    </script>
@endpush
