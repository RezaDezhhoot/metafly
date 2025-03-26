@use('App\Enums\PageAction')
@use('App\Enums\CategoryType')
<div wire:init="init" class="h-100">
    @section('title', __('pages.pages.action',['item' => __('general.sidebar.post')]).(' '.$header ?? '') )
    <x-admin.form-control cancel="{{ route('point.index') }}" deleteAble="{{$mode === PageAction::UPDATE}}"  title="{{__('general.sidebar.post')}}"/>
    <div class="card card-custom h-100 gutter-b  example example-compact">
        <div class="card-header">
            <h3 class="card-title">{{ $header }}</h3>
        </div>
        <x-admin.forms.validation-errors/>
        <x-admin.nav-tabs-list>
            <x-admin.nav-tabs-item :active="$tab == 'post'" title="{{__('general.headers.post')}}" key="tab" value="post" icon="far fa-newspaper"/>
            <x-admin.nav-tabs-item :active="$tab == 'content'" title="{{__('general.content')}}" key="tab" value="content" icon="fas fa-pen"/>
        </x-admin.nav-tabs-list>
        <div class="card-body {{ $tab == 'post' ? '' : 'd-none' }}">
            <x-admin.form-section>
                <x-admin.forms.input width="4" type="text" :required="true" id="title" label="{{__('general.title')}}" wire:model.defer="title"/>
                <x-admin.forms.dropdown width="2" id="status" :required="true" :data="$data['status']" label="{{__('general.status')}}" wire:model.defer="status"/>
                <x-admin.forms.input width="6" type="text"  id="sub_title" label="{{__('general.sub_title')}}" wire:model.defer="sub_title"/>
                <x-admin.forms.select2 :multiple="true" width="10" text="title" :data="$post?->categories?->toArray()" id="categories" label="{{__('general.category')}}" ajaxUrl="{{route('category.feed',['type'=> CategoryType::POST])}}" wire:model.defer="categories"/>
                <x-admin.forms.input width="2" type="number" :required="true" id="study_time" label="{{__('general.study_time')}}" wire:model.defer="study_time"/>

                <x-admin.forms.checkbox id="slider" label="{{__('general.slider')}}"  wire:model.defer="slider"/>

                <x-admin.forms.lfm-standalone id="image" :required="true" label="{{__('general.image')}}" :file="$image"  wire:model.defer="image"/>
                <x-admin.forms.text-area :required="true" id="seo_keywords" label="{{__('general.seo_keywords')}}" help="{{__('general.descriptions.separate_words_with_commas')}}" wire:model.defer="seo_keywords"/>
                <x-admin.forms.text-area :required="true" id="seo_description" label="{{__('general.seo_description')}}" wire:model.defer="seo_description"/>

                <livewire:topic.topic-form-component :topicable="$post" />
            </x-admin.form-section>
        </div>
        <div class="card-body {{ $tab == 'content' ? '' : 'd-none' }}">
            <x-admin.form-section>
                <div class="col-12  table-responsive">
                    <button wire:click="addContent" class="btn my-2 btn-outline-primary">{{__('general.add')}} <i class="fas fa-plus"></i></button>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('general.title') }}</th>
                            <th>{{ __('general.actions.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($content as $k => $v)
                            <tr data-toggle="collapse" data-target="#content{{$k}}"  class="accordion-toggle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v['title'] ?? '-' }}</td>
                                <td>
                                    <x-admin.delete-btn onclick="deleteContent('{{$k}}')"  />
                                </td>
                            </tr>
                            <tr >
                                <td colspan="5" >
                                    <div class="accordian-body collapse" id="content{{$k}}" wire:ignore.self>
                                        <x-admin.forms.input  type="text" :required="true" id="content{{$k}}" label="{{__('general.title')}}" wire:model.live="content.{{$k}}.title"/>
                                        <x-admin.forms.full-text-editor id="contentb{{$k}}" :required="true" label="{{__('general.body')}}" wire:model.defer="content.{{$k}}.body"/>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
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
        function deleteContent(id) {
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
                    @this.call('deleteContent', id)
                }
            })
        }
    </script>
@endpush
