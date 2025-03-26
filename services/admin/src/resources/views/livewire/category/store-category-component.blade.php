@use('App\Enums\PageAction')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.category')]).(' '.$header ?? '') )

    <x-admin.form-control cancel="{{ route('category.index', $type) }}" deleteAble="{{$mode === PageAction::UPDATE}}"  title="{{__('general.sidebar.category')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section>
                <x-admin.forms.input width="6" type="text" :required="true" id="title" label="{{__('general.title')}}" wire:model.defer="title"/>
                @if(! $category || $category->parent)
                    <x-admin.forms.select2  width="6" id="parent" :data="$category?->parent?->toArray()" text="title" label="{{__('general.parent')}}" ajaxUrl="{{route('category.feed' ,[$type , true] )}}" wire:model.defer="parent" />
                @endif
                <x-admin.forms.select2 :multiple="true" text="text" :data="$category?->points?->toArray()" id="points" label="{{__('general.points')}}" ajaxUrl="{{route('point.feed')}}" wire:model.defer="points"/>

                <x-admin.forms.lfm-standalone id="image" label="{{__('general.image')}}" :file="$image" wire:model.defer="image"/>
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
