@section('script')
<script>
    function toggleModal() {
        const body = document.querySelector('body');
        const modal = document.querySelector('.modal');
        modal.classList.toggle('opacity-0');
        modal.classList.toggle('pointer-events-none');
        body.classList.toggle('modal-active');
    };

    const overlay = document.querySelector('.modal-overlay');
    overlay.addEventListener('click', toggleModal);

    var closeModal = document.querySelectorAll('.modal-close');
    for (var i = 0; i < closeModal.length; i++) {
        closeModal[i].addEventListener('click', toggleModal);
    }

    var openModal = document.querySelectorAll('.modal-open');
    for (var i = 0; i < openModal.length; i++) {
        openModal[i].addEventListener('click', function(event) {
            event.preventDefault();
            toggleModal();
        })
    }

    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ('key' in evt) {
            isEscape = (evt.key === 'Escape' || evt.key === 'Esc');
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape && document.body.classList.contains('modal-active')) {
            toggleModal();
        }
    };

    function comToggleModal() {
        const comBody = document.querySelector('body');
        const comModal = document.querySelector('.com-modal');
        comModal.classList.toggle('opacity-0');
        comModal.classList.toggle('pointer-events-none');
        comBody.classList.toggle('modal-active');
    };

    const comOverlay = document.querySelector('.com-modal-overlay');
    comOverlay.addEventListener('click', comToggleModal);

    var comCloseModal = document.querySelectorAll('.com-modal-close');
    for (var i = 0; i < comCloseModal.length; i++) {
        comCloseModal[i].addEventListener('click', comToggleModal);
    }

    var comOpenModal = document.querySelectorAll('.com-modal-open');
    for (var i = 0; i < comOpenModal.length; i++) {
        comOpenModal[i].addEventListener('click', function(event) {
            event.preventDefault();
            comToggleModal();
        })
    }

    document.onkeydown = function(evt) {
        evt = evt || window.event;
        var isEscape = false;
        if ('key' in evt) {
            isEscape = (evt.key === 'Escape' || evt.key === 'Esc');
        } else {
            isEscape = (evt.keyCode === 27);
        }
        if (isEscape && document.comBody.classList.contains('modal-active')) {
            comToggleModal();
        }
    }

    const modalOpen = (url) => {
        document.comDeleteForm.action = url;
    }

    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    dropZone.addEventListener('dragover', function(event) {
        event.stopPropagation();
        event.preventDefault();
        this.style.background = '#e1e7f0';
    }, false);

    dropZone.addEventListener('dragleave', function(event) {
        event.stopPropagation();
        event.preventDefault();
        this.style.background = '#ffffff';
    }, false);


    dropZone.addEventListener('drop', function(event) {
        event.stopPropagation();
        event.preventDefault();
        this.style.background = '#ffffff';
        var files = event.dataTransfer.files;
        fileInput.files = files;
    }, false);
</script>
@endsection
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $project->name }} ({{ $project->key }})
        </h2>
    </x-slot>

    <x-slot name="sidemenu">
        <x-side-menu-link :href="route('tasks.index', ['project' => $project->id])" :active="request()->routeIs('tasks.index')">
            {{ __('Tasks') }}
        </x-side-menu-link>
        <x-side-menu-link :href="route('tasks.create', ['project' => $project->id])" :active="request()->routeIs('tasks.create')">
            {{ __('Task Create') }}
        </x-side-menu-link>
    </x-slot>

    <div>
        <div class="mx-auto">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Task Edit') }}
                    </h3>
                </div>
            </div>
        </div>
        <x-flash-message />
        <form method="POST" action="{{ route('tasks.update', ['project' => $project->id, 'task' => $task]) }}">
            @csrf
            @method('PUT')

            <!-- Validation Errors -->
            <x-validation-errors :errors="$errors" />

            <!-- Navigation -->
            <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-end">
                <x-link-button class="m-2" :href="route('tasks.index', ['project' => $project->id])">
                    {{ __('Update Cancel') }}
                </x-link-button>
                <x-button class="m-2 px-10">
                    {{ __('Update') }}
                </x-button>
            </div>

            <div class="flex flex-col px-8 pt-6 mx-6 rounded-md bg-white">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6">
                        <x-label for="task_kind_id" :value="__('Task Kind')" class="{{ $errors->has('task_kind_id') ? 'text-red-600' :'' }}" />
                        <x-select :options="$task_kinds" id="task_kind_id" class="block mt-1 w-full {{ $errors->has('task_kind_id') ? 'border-red-600' :'' }}" name="task_kind_id" :value="old('task_kind_id', $task->task_kind_id)" required autofocus />
                    </div>

                    <div class="md:w-full px-3 mb-6">
                        <x-label for="name" :value="__('Task Name')" class="{{ $errors->has('name') ? 'text-red-600' :'' }}" />
                        <x-input id="name" class="block mt-1 w-full {{ $errors->has('name') ? 'border-red-600' :'' }}" type="text" name="name" :value="old('name', $task->name)" placeholder="?????????" required autofocus />
                    </div>
                </div>

                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-full px-3 mb-6">
                        <x-label for="detail" :value="__('Task Detail')" class="{{ $errors->has('detail') ? 'text-red-600' :'' }}" />
                        <x-textarea id="detail" class="block mt-2 w-full {{ $errors->has('detail') ? 'border-red-600' :'' }}" type="text" name="detail" :value="old('detail', $task->detail)" placeholder="???????????????" rows="3" />
                    </div>
                </div>

                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/4 px-3 mb-6">
                        <x-label for="task_status_id" :value="__('Task Status')" class="{{ $errors->has('task_status_id') ? 'text-red-600' :'' }}" />
                        <x-select :options="$task_statuses" id="task_status_id" class="block mt-1 w-full {{ $errors->has('task_status_id') ? 'border-red-600' :'' }}" type="text" name="task_status_id" :value="old('task_status_id', $task->task_status_id)" required autofocus />
                    </div>

                    <div class="md:w-1/4 px-3 mb-6">
                        <x-label for="assigner_id" :value="__('Assigner')" class="{{ $errors->has('assigner_id') ? 'text-red-600' :'' }}" />
                        <x-select :options="$assigners" id="assigner_id" class="block mt-1 w-full {{ $errors->has('assigner_id') ? 'border-red-600' :'' }}" type="text" name="assigner_id" :value="old('assigner_id', $task->assigner_id)" autofocus />
                    </div>
                    <div class="md:w-1/4 px-3 mb-6">
                        <x-label for="task_category_id" :value="__('Task Category')" class="{{ $errors->has('task_category_id') ? 'text-red-600' :'' }}" />
                        <x-select :options="$task_categories" id="task_category_id" class="block mt-1 w-full {{ $errors->has('task_category_id') ? 'border-red-600' :'' }}" type="text" name="task_category_id" :value="old('task_category_id', $task->task_category_id)" autofocus />
                    </div>
                    <div class="md:w-1/4 px-3 mb-6">
                        <x-label for="due_date" :value="__('Due Date')" class="{{ $errors->has('due_date') ? 'text-red-600' :'' }}" />
                        <x-datepicker id="due_date" class="block mt-1 w-full {{ $errors->has('due_date') ? 'border-red-600' :'' }}" type="text" name="due_date" :value="$task->due_date ?? old('due_date')" autofocus />
                    </div>
                </div>
            </div>
        </form>

        <form name="deleteform" method="POST" action="{{ route('tasks.destroy', ['project' => $project->id, 'task' => $task]) }}">
            @csrf
            @method("Delete")
            <!-- Navigation -->
            <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-start">
                <x-button class="modal-open m-2 px-10 bg-red-600 text-white hover:bg-red-700 active:bg-red-900 focus:border-red-900 ring-red-300">
                    {{ __('Delete') }}
                </x-button>
            </div>

            <!--Modal-->
            <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                    <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                        <span class="text-sm">(Esc)</span>
                    </div>

                    <div class="modal-content py-4 text-left px-6">
                        <div class="flex justify-between items-center pb-3">
                            <p class="text-2xl font-bold">{{ __('Are you sure you want to delete this task?') }}</p>
                            <div class="modal-close cursor-pointer z-50">
                                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                </svg>
                            </div>
                        </div>

                        <p>{{ __('Are you sure you want to delete this task? Once a task is deleted, all of its resources and data will be permanently deleted.') }}</p>

                        <div class="flex justify-end pt-2">
                            <x-link-button class="modal-close m-2" href="#">
                                {{ __('Cancel') }}
                            </x-link-button>
                            <x-button class="m-2 px-10 bg-red-600 text-white hover:bg-red-700 active:bg-red-900 focus:border-red-900 ring-red-300">
                                {{ __('Delete') }}
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('images.store', ['project' => $project->id, 'task' => $task->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col px-8 pt-2 mx-6 rounded-md bg-white">
                <x-label for="Image" :value="__('Image')" />
                <div id="drop-zone" style="border: 1px solid; padding: 30px ;" class="md:w-full px-3 mb-6">
                    <p>??????????????????????????????????????????????????????</p>
                    <input type="file" name="file_img" id="file-input">
                    <x-button type='submit' class="btn btn-primary">{{__('Store Image')}}</x-button>
                </div>
            </div>
        </form>
        @foreach($images as $image)
        <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div><img src="{{ asset('/storage/' . $image->image ) }}" width="130" height="100"></div>
        </div>
        <form method="POST" action="{{ route('images.destroy', ['project' => $project->id , 'task' => $task->id , 'image' => $image ]) }}" enctype="multipart/form-data">
            @csrf
            @method("Delete")
            <x-button class="m-2 px-10 bg-red-600 text-white hover:bg-red-700 active:bg-red-900 focus:border-red-900 ring-red-300">
                {{ __('Delete') }}
            </x-button>
        </form>
        @endforeach


        <form method="POST" action="{{ route('comments.store', ['project' => $project->id, 'task' => $task->id]) }}">
            @csrf

            <div class="flex flex-col px-4 pt-6 mx-4 rounded-md bg-white">
                <div class="md:w-full px-3 mb-16">
                    <x-label for="comment" :value="__('Comment')" class="{{ $errors->has('comment') ? 'text-red-600' :'' }}" />
                    <x-textarea id="comment" class="block mt-2 w-full {{ $errors->has('comment') ? 'border-red-600' :'' }}" type="text" name="comment" placeholder="????????????????????????????????????" rows="2" />
                </div>
                <div class="md:w-1/4 px-3 mb-16">
                    <x-button>
                        ??????????????????
                    </x-button>
                </div>
            </div>
        </form>

        <div class="flex flex-col px-4 pt-6 mx-4 rounded-md bg-white">
            <div class="md:w-full px-3 mb-6">
                @foreach($comments as $id => $comment)
                <tr>
                    <th>{{ $comment->commenter->name }}</th>
                    <th>{{ $comment->updated_at }}</th>
                    <div class="md:w-full px-3 mb-6">
                        <p>{!!nl2br(e($comment->comment))!!}</p>
                    </div>
                    @if(Auth::user()->id === $comment->user_id)
                    <div class="max-w-full mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-start">
                        @php
                        $urlDeleteComment = route('comments.destroy', ['project' => $project->id, 'task' => $task, 'comment' => $comment]);
                        @endphp
                        <x-button class="com-modal-open m-2 px-10 bg-red-600 text-white hover:bg-red-700 active:bg-red-900 focus:border-red-900 ring-red-300" id="deleteCom" onclick=" modalOpen('{{$urlDeleteComment}}')">
                            {{ __('Delete') }}
                        </x-button>
                    </div>
                    @endif
                </tr>
                @endforeach

                <!--Modal-->
                <div class="com-modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                    <div class="com-modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                    <div class="com-modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                        <div class="com-modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                            <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                            <span class="text-sm">(Esc)</span>
                        </div>
                        <div class="com-modal-content py-4 text-left px-6">
                            <div class="flex justify-between items-center pb-3">
                                <p class="text-2xl font-bold">{{ __('Are you sure you want to delete this comment?') }}</p>
                                <div class="com-modal-close cursor-pointer z-50">
                                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p>{{ __('Are you sure you want to delete this comment? Once a comment is deleted, all of its resources and data will be permanently deleted.') }}</p>

                            <div class="flex justify-end pt-2">
                                <x-link-button class="com-modal-close m-2" href="#">
                                    {{ __('Cancel') }}
                                </x-link-button>
                                <form name="comDeleteForm" method="POST" action="">
                                    @csrf
                                    @method("Delete")
                                    <x-button class="m-2 px-10 bg-red-600 text-white hover:bg-red-700 active:bg-red-900 focus:border-red-900 ring-red-300">
                                        {{ __('Delete') }}
                                    </x-button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</x-app-layout>
