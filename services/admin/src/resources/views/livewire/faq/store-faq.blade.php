@use('App\Enums\PageAction')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.faq')]).(' '.$header ?? '') )
    <x-admin.form-control deleteAble="{{$mode === PageAction::UPDATE}}"  title="{{__('general.sidebar.faq')}}"/>
    <div class="card card-custom h-100 gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <div class="card-body ">
            <x-admin.form-section label="{{ __('general.headers.basic') }}">
                <x-admin.forms.input width="6" type="text"  :required="true" id="question" label="{{__('general.question')}}" wire:model.defer="question"/>

                <x-admin.forms.full-text-editor id="answer" :required="true" label="{{__('general.answer')}}" wire:model.defer="answer"/>
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

