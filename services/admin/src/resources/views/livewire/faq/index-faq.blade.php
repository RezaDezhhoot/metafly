@use('App\Enums\PageAction')
<div wire:init="init">
    @section('title', __('pages.pages.index',['item' => __('general.sidebar.faqs')]) )
    <x-admin.form-control :store="false" title="{{__('general.sidebar.faqs')}}"/>
    <div id="accordion">
        <div class="card">
            <div class="card-header" id="headingOne">
                <button class="btn btn-link" data-toggle="collapse" data-target="#create-new" aria-expanded="true" aria-controls="collapseOne">
                    {{  __('pages.pages.create' , ['item' => __('general.sidebar.faq')]) }}
                </button>
            </div>
            <div id="create-new" class="collapse" wire:ignore.self aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <x-admin.forms.validation-errors/>
                    <div class="row">
                        <x-admin.forms.input type="text"  :required="true" id="question" label="{{__('general.question')}}" wire:model.defer="question"/>
                        <x-admin.forms.full-text-editor id="answer" :required="true" label="{{__('general.answer')}}" wire:model.defer="answer"/>
                        <div class="col-12">
                            <x-admin.button class="btn btn-outline-primary font-weight-bolder btn-sm" content="{{ __('general.actions.create') }}" wire:click="store()"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            @include('livewire.includes.advance-table')
            <div class="row">
                <div class="col-12  table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.question') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody >
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ str()->limit($item->question) }}</td>
                                <td>
                                    <x-admin.edit-btn href="{{ route('faq.store',[PageAction::UPDATE , $item->id]) }}"/>
                                    <x-admin.delete-btn onclick="deleteItem('{{$item->id}}')"  />
                                </td>
                            </tr>
                        @empty
                            <td class="text-center" colspan="4">
                                {{ __('general.messages.no_data') }}
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if(sizeof($items) > 0)
                {{$items->links('layouts.paginate')}}
            @endif
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
