@extends("template.main")

@section('styles')
    <link href="{{ asset('css/todos.css') }}" rel="stylesheet">
@endsection

@section('inblock')
    <form method="post" id="post_form">
    @csrf
    @if ($todos->count() != 0)
        <div style="position: absolute" id="sync_div"></div>
        <div class="todo__line_grid_layout" id="list_of_todos">
            @foreach ($todos as $sheet)
                <div class="todo__block" id="todo__block_{{$sheet->id}}">
                    <a class="todo__delete_object" account="{{$sheet->id}}" onclick="delete_table(this);">
                        <h2>удалить?</h2>
                    </a>
                    <p>
                        <input maxlength="60" oninput="sync_information({{$sheet->id}})" placeholder="Оглавление..." value="{{$sheet->title}}">
                    </p>
                    <p>
                        <textarea maxlength="250" oninput="sync_information({{$sheet->id}}); autosize(this)" placeholder="Что надо сделать...">{{$sheet->text}}</textarea>
                    </p>
                    <label name="completed_{{$sheet->id}}" class="toggler-wrapper style-1">
                        <input type="checkbox" onchange="sync_information({{$sheet->id}})" 
                            @if ($sheet->compeleted)
                                checked
                            @endif>
                        <div class="toggler-slider">
                            <div class="toggler-knob"></div>
                        </div>
                    </label>
                    <label for="completed_{{$sheet->id}}">
                        Завершенно?
                    </label>
                </div>
            @endforeach
            <div id="create_new_todo">
                <a class="todo__delete_object" onclick="create_todo_post();"><h1>новое дело</h1></a>
            </div>
        </div>
    @else
        <h1 id="not_exists_message">
            <center>У вас пока нет ни одной записи</center>
            <a class="todo__delete_object" onclick="create_todo_post();"><center>Создать</center></a>
        </h1>
    @endif
    </form>
    <script>
        const csrftoken = document.querySelector('[name=_token]').value;
        var to_sync_id = new Set();
        var list_of_todos = $('#list_of_todos')[0];
        var sync_div = $("#sync_div")[0];
        var timer = null;
        var sync_div_timer = null;
        function sync_div_timer_func(response) {
            console.log(response)
            if (response == "OK") {
                sync_div.style.color = "lightgreen";
                sync_div.textContent = "готово!";
            } else {
                sync_div.style.color = "red";
                sync_div.textContent = "ошибка!";
            }

            if (sync_div_timer) {clearTimeout(sync_div_timer);}
            sync_div_timer = setTimeout(
              () => {
                sync_div.textContent = ""
              },
              2000
            );
        }
        function send_data(id) {
            let children = $(`#todo__block_${id}`)[0].children;

            $.ajax({
                headers: {'X-CSRF-TOKEN': csrftoken},
                url: `{{ route('todos_update', '') }}/${id}`,
                data: {
                    'title': children[children.length - 4].children[0].value || "",
                    'text': children[children.length - 3].children[0].value || "",
                    'finished': children[children.length - 2].children[0].checked,
                },
                //data,
                //cache: false,
                //processData: false,
                //contentType : false,
                type: 'PUT',
                success: (response) => {
                    sync_div_timer_func(response)
                    to_sync_id.delete(id);
                },
                error: sync_div_timer_func,
            });
        }
        function sync_information(id) {
            if (timer) {clearTimeout(timer);}
            sync_div.style.color = "black";
            sync_div.textContent = "синхронизация";
            to_sync_id.add(id);
            timer = setTimeout(
                function() {
                    to_sync_id.forEach((i, val, set) => {
                        send_data(val);
                    });
                },
                1000
            );
            
        }

        function delete_element(el) {
            el.parentNode.removeChild(el);
        }
        function create_todo_post() {
            if (document.querySelector("#not_exists_message")) { not_exists_message.parentNode.removeChild(not_exists_message);}

            //$.ajaxSetup({
            //    headers: {
            //        'X-CSRF-TOKEN': csrftoken,//$('meta[name="_token"]').attr('content')
            //    }
            //});

            $.ajax({
                headers: {'X-CSRF-TOKEN': csrftoken},
                url: "{{ route('todos_create') }}",
                type: 'POST',
                success: function (response) {
                    if (!list_of_todos) { 
                        list_of_todos = document.createElement("div");
                        list_of_todos.className = "todo__line_grid_layout";
                        list_of_todos.id = "list_of_todos";
                        sync_div = document.createElement("div");
                        sync_div.style = "position: absolute;";
                        sync_div.id = "sync_div";
                        list_of_todos.appendChild(sync_div);
                        $("#post_form")[0].appendChild(list_of_todos);
                    }

                    let todo_add_new = document.querySelector('#create_new_todo');
                    if (todo_add_new) { 
                        delete_element(todo_add_new);
                    }

                    let this_id = response.id;
                    let div1 = document.createElement("div")
                    div1.className = "todo__block"
                    div1.id = `todo__block_${this_id}`
                    div1.innerHTML = `
                                    <a class="todo__delete_object" name="todo__delete_account" account="${this_id}" onclick="delete_table(this);"><h2>удалить?</h2></a>
                                    <p>
                                        <input maxlength="60" oninput="sync_information(${this_id})" placeholder="Оглавление..." value="">
                                    </p>
                                    <p>
                                        <textarea oninput="sync_information(${this_id})); autosize(this)" maxlength="250" placeholder="Что надо сделать..."></textarea>
                                    </p>
                                    <label class="toggler-wrapper style-1">
                                    <input type="checkbox" onchange="sync_information(${this_id})">
                                    <div class="toggler-slider">
                                        <div class="toggler-knob"></div>
                                    </div>
                                    </label>
                                    <label for="completed_${this_id}">Завершенно?</label>`;
                    let div2 = document.createElement("div");
                    div2.id = `create_new_todo`;
                    div2.innerHTML = `<a class="todo__delete_object" onclick="create_todo_post();"><h1>новое дело</h1></a>`;

                    list_of_todos.appendChild(div1);
                    list_of_todos.appendChild(div2);
                },
                error: function (response) {
                }
            });
        }

        function autosize(el) {
            el.style.cssText = 'height:auto; padding:0';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        }
        function delete_table(el) {
            el = el || this;
            let elem_id = el.getAttribute('account');
            // also we must send that we delete this block

            delete_element(document.getElementById("todo__block_" + elem_id));

            $.ajax({
                headers: {'X-CSRF-TOKEN': csrftoken},
                url: `${"{{ route('todos_destroy', '') }}"}/${elem_id}`,
                type: 'DELETE',
                success: function (response) {
                },
                error: function (response) {
                }
            });
        }
    </script>
@endsection