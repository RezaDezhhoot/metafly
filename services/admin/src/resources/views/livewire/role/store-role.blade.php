@use('App\Enums\PageAction')
<div wire:init="init">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.role')]).($title ? " - $title" : '') )
    <x-admin.form-control cancel="{{ route('role.index') }}" deleteAble="{{$mode === PageAction::UPDATE}}" title="{{__('general.sidebar.role')}}"/>
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body">
            <x-admin.form-section label="{{__('general.headers.role')}}">
                <x-admin.forms.input type="text" id="title" label="{{__('general.title')}}" wire:model.defer="title"/>
            </x-admin.form-section>
            <x-admin.form-section label="{{__('general.headers.permission')}}">
                <div class="row w-100 p-5">
                    @foreach($permissions as $key => $permission)
                        <div class="col-12 pb-4 col-md-3">
                            <div class="card shadow-sm w-100">
                                <div class="card-header">
                                    {{ __('general.modules.'.$key) }}
                                </div>
                                <div class="card-body">
                                    @foreach($permission as $item)
                                        <x-admin.forms.checkbox label="{{$item['title']}}" value="{{$item['name']}}"
                                                                id="permissions-{{$item['name']}}"
                                                                wire:model.defer="permissionSelected"/>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
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
