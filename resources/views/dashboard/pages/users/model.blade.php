<div class="modal fade" id="usersModal" style="display: none;" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">


                    <div class="row mb-3">
                        <div id="iamges"></div>
                        <label for="photos">Upload Image</label>
                        <input type="file" name="photos[]" id="photos" class="form-control" multiple>
                    </div>


                    <div class="row mb-3">
                        <label for="f_name" class="col-md-4 col-form-label text-md-end">{{ __('First name') }}</label>

                        <div class="col-md-6">
                            <input id="f_name" type="text"
                                class="form-control @error('f_name') is-invalid @enderror" name="f_name"
                                value="{{ old('f_name') }}" required autocomplete="f_name">
                            <div class="alert alert-danger d-none" style="display: none"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="m_name"
                            class="col-md-4 col-form-label text-md-end">{{ __('Middle name') }}</label>

                        <div class="col-md-6">
                            <input id="m_name" type="text"
                                class="form-control @error('m_name') is-invalid @enderror" name="m_name"
                                value="{{ old('m_name') }}" required autocomplete="m_name">

                            <div class="alert alert-danger d-none" style="display: none"></div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="l_name" class="col-md-4 col-form-label text-md-end">{{ __('Last name') }}</label>

                        <div class="col-md-6">
                            <input id="l_name" type="text"
                                class="form-control @error('l_name') is-invalid @enderror" name="l_name"
                                value="{{ old('l_name') }}" required autocomplete="l_name">

                            <div class="alert alert-danger d-none" style="display: none"></div>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="phone"
                            class="col-md-4 col-form-label text-md-end">{{ __('phone Address') }}</label>

                        <div class="col-md-6">
                            <input id="phone" type="tele"
                                class="form-control @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone') }}" required autocomplete="phone">

                            <div class="alert alert-danger d-none" style="display: none"></div>

                        </div>
                    </div>


                    <div class="row mb-3">
                        <label for="email"
                            class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">


                            <div class="alert alert-danger d-none" style="display: none"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                autocomplete="new-password">
                            <div class="alert alert-danger d-none" style="display: none"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm"
                            class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="licenses"
                            class="col-md-4 col-form-label text-md-end">{{ __('licenses') }}</label>

                        <div class="col-md-6">
                            <input id="licenses" type="text"
                                class="form-control licenses @error('licenses') is-invalid @enderror" name="licenses[]"
                                value="{{ old('licenses') }}" required autocomplete="licenses">

                                <div class="btn-new-licesen"><i class="fa fa-plus"></i></div>
                            <div class="alert alert-danger d-none" style="display: none"></div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>

    </div>

</div>

@push('js')
    <script>
        let id, body = $("body"),
            $btnSubmit = $("button[type=submit]"),
            $table = $("#usersTable"),
            $form = $("form"),
            $method = `<input type="hidden" name="_method" value="PUT">`,
            $model = $("#usersModal")



        body.on("click", ".btn-new-licesen", function(e) {

            let a = $(".licenses").parent().parent().clone()

            a.insertBefore(".modal-footer")

        })


        $form.submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            ajax("{{ route('dashboard.clients.store') }}", formData)
        })


        body.on("click", ".btn-block-user", function(e) {
            e.preventDefault();

            const $this = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: `You want ${$this.text()} ${$this.data("name")}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: `Yes, ${$this.text()} it!`

            }).then((result) => {
                if (result.isConfirmed) {
                    ajax($(this).data("route"))
                }
            })
        });

        body.on("click", ".btn-edit-user", function() {
            resetForm()

            var data = JSON.parse(JSON.stringify($(this).data("data")));

            $btnSubmit.attr("data-method", "put")
                .attr("data-id", data.id);

            $form.append(`<input type=hidden value=${data.id} name="id" >`)


            data.images.forEach(element => {
                console.log(element.image);
                $("#iamges").append(
                    `<img src='{{ asset('') }}/${element.image}'  style='    width: 20%;'>`)
            });

            for (const [key, value] of Object.entries(data)) {
                if (key !== "deleted_at") {
                    if (key === "type") {
                        $(`#${key} option[value=${value === "admin" ? 1 : 0}]`).attr("selected", true).trigger(
                            'change')
                    }
                    if (key === "status") {
                        $(`#${value}`).prop("checked", true);
                    }
                    $(`#${key}`).val(value)
                }
            }

            $model.modal("show");
        });


        $(".btn-add").click(function() {
            resetForm()
        })


        function resetForm() {
            $form[0].reset();
            $form.trigger("reset");
            $('input[name=id]').remove();
        }

        function ajax(url, formData) {
            $.ajax({
                url: url,
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.status === 1) {
                        Swal.fire(
                            'Congratulation',
                            data.msg,
                            'success'
                        )
                        if ($btnSubmit.data("method") === "put") {
                            $btnSubmit.removeAttr("data-method");
                            $("input[name=_method]").remove();
                        }
                        $model.modal("hide");
                        $table.DataTable().draw();
                        $form[0].reset();
                        $form.trigger("reset");
                        $(".alert").addClass("d-none")
                    }
                },
                error: function(data, textStatus, jqXHR) {
                    const response = data.responseJSON;
                    console.log(response)
                    if (response) {
                        for (const [key, value] of Object.entries(response.errors)) {
                            $(`#${key}`)
                                .addClass("is-invalid")
                                .parent()
                                .find(".alert")
                                .removeClass("d-none")
                                .text(value[0])
                                .show()
                        }
                    }
                },
            });
        }
    </script>
@endpush
