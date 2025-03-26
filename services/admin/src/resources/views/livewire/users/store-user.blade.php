@use('App\Enums\PageAction')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.user')]).($name ? " - $name" : '') )
    <x-admin.form-control cancel="{{ route('user.index') }}" deleteAble="{{$mode === PageAction::UPDATE}}"  title="{{__('general.sidebar.user')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title iran-sans">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>

        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input width="3" type="text" :required="true" id="name" label="{{__('general.name')}}" wire:model.defer="name"/>
                <x-admin.forms.input width="3" type="email" :required="true" id="email" label="{{__('general.email')}}" wire:model.defer="email"/>
                <x-admin.forms.input width="3" type="text" :required="true" id="phone" label="{{__('general.phone')}}" wire:model.defer="phone"/>
                <x-admin.forms.input width="3" help="{{__('general.descriptions.valid_password')}}" type="password" :required="$mode === PageAction::UPDATE" id="password" label="{{__('general.password')}}" wire:model.defer="password"/>
            </x-admin.form-section>

            <x-admin.form-section label="{{ __('general.headers.role') }}">
                <x-admin.forms.select2 :multiple="true" :data="$user?->roles?->toArray()" text="name" width="12" id="roles" label="{{__('general.role')}}" ajaxUrl="{{route('role.feed')}}" wire:model.defer="roles"/>
            </x-admin.form-section>

        </div>

    </div>
</div>
@push('scripts')
    <script>
        function deleteLink(id) {
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
                @this.call('deleteLink', id)
                }
            })
        }

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

